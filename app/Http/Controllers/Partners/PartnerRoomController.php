<?php

namespace App\Http\Controllers\Partners;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Account;
use App\Models\Facility;
use App\Models\Hotel;
use App\Models\Review;
use App\Models\Room;
use App\Services\SubmissionService;
use App\Support\CurrentAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;
class PartnerRoomController extends Controller {

    protected function authorize(Room $room): void {
        $accountId = (int) app(CurrentAccount::class)->id();
        abort_if((int) $room->account_id !== $accountId, 403, 'Accès refusé.');
    }

    public function index(Request $request) {
        $accountId = app(CurrentAccount::class)->id();

        $status = $request->string('status')->toString(); // all|active|inactive
        $period = $request->string('period')->toString(); // last_month|last_7_days

        $q = Room::query()
            ->whereHas('hotel', fn($h)=>$h->where('account_id',$accountId))
            ->with(['hotel:id,name','hotel.country:id,name'])
            ->withCount(['reservations','reviews','views'])
            ->withExists(['submissions as has_pending_submission' => function($s){
                $s->whereHas('status', fn($st)=>$st->where('slug','pending'));
            }]);

        if ($status === 'active')   $q->where('status',1);
        if ($status === 'inactive') $q->where('status',0);
        if ($period === 'last_month')  $q->where('created_at','>=',now()->subMonth());
        if ($period === 'last_7_days') $q->where('created_at','>=',now()->subDays(7));

        $rooms = $q->latest()->paginate(10)->withQueryString();

        // KPIs scoppés au compte
        $base = Room::whereHas('hotel', fn($h)=>$h->where('account_id',$accountId));
        $total    = (clone $base)->count();
        $active   = (clone $base)->where('status',1)->count();
        $inactive = $total - $active;
        $avg      = (clone $base)->join('reviews','reviews.reviewable_id','=','rooms.id')
                     ->where('reviews.reviewable_type',Room::class)->avg('reviews.rating');
        $averageRating = number_format((float)($avg ?? 0),2);
        $totalReviews  = Review::where('reviewable_type',Room::class)
                           ->whereIn('reviewable_id',(clone $base)->pluck('id'))->count();

        // listes pour modal create
        $facilities = Facility::where('status',1)->orderBy('name')->get();
        // hôtels du compte courant uniquement
        $hotels = Hotel::where('account_id',$accountId)->orderBy('name')->get();

        return view('backend.partners.rooms.index', compact(
            'rooms','total','active','inactive','averageRating','totalReviews','facilities','hotels'
        ));
    }


    public function create() {
        $accountId = app(CurrentAccount::class)->id();
        $facilities = Facility::where('status',1)->orderBy('name')->get();
        $hotels = Hotel::where('account_id',$accountId)->orderBy('name')->get();
        $accounts = Account::query()
        ->where('status',1)
        ->whereHas('modules', fn($m)=>$m->where('slug','artisan'))
        ->orderBy('name')
        ->get();

        return view('backend.partners.rooms.create', compact('facilities','hotels', 'accounts'));
    }


    public function store(Request $request, SubmissionService $sub)  {
        $accountId = app(CurrentAccount::class)->id();

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'hotel_id' => 'required|exists:hotels,id',
            'type' => 'nullable|string|max:100',
            'capacity' => 'nullable|integer|min:1',
            'price' => 'nullable|numeric',
            'info' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:4096',
            'video' => 'nullable|file|mimes:mp4,avi,mov|max:10240',
            'video_url' => 'nullable|url|max:255',
            'facilities' => 'array|nullable',
            'facilities.*' => 'exists:facilities,id',
        ]);

        abort_unless(Hotel::where('id',$data['hotel_id'])->where('account_id',$accountId)->exists(), 403);

        $room = new Room();
        $room->fill(collect($data)->except(['facilities','image','video'])->toArray());
        $room->status = 0;
        $room->save();

        $room->facilities()->sync($request->input('facilities', []));



        $payload = Arr::except($data, ['facilities','image','video']);
        if ($request->hasFile('image')) {
            $payload['image_pending'] = $request->file('image')->store('rooms/images','pending');
        }
        if ($request->hasFile('video')) {
            $payload['video_pending'] = $request->file('video')->store('rooms/videos','pending');
        }

        $sub->submit($room, $payload, 'create');

        return redirect()->route('media.index', [
            'type' => 'room',
            'key'  => $room->slug ?: $room->getKey(),
        ])->with('success','Chambre créée. En attente de validation... Ajoutez des médias.');
    }



    public function edit(Room $room) {
        // sécurité compte
        abort_unless(optional($room->hotel)->account_id === app(CurrentAccount::class)->id(), 403);

        $facilities = Facility::where('status',1)->orderBy('name')->get();
        $hotels = Hotel::where('account_id', app(CurrentAccount::class)->id())->orderBy('name')->get();

        $accounts = Account::query()
        ->where('status',1)
        ->whereHas('modules', fn($m)=>$m->where('slug','hotel'))
        ->orderBy('name')
        ->get(['id','name','is_verified']);

        return view('backend.partners.rooms.edit', compact('room','facilities','hotels', 'accounts'));
    }


    public function update(Request $request, \App\Models\Room $room, SubmissionService $sub) {
        $accountId = app(CurrentAccount::class)->id();
        abort_unless(optional($room->hotel)->account_id === $accountId, 403);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'hotel_id' => 'required|exists:hotels,id',
            'type' => 'nullable|string|max:100',
            'capacity' => 'nullable|integer|min:1',
            'price' => 'nullable|numeric',
            'info' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:4096',
            'video' => 'nullable|file|mimes:mp4,avi,mov|max:10240',
            'video_url' => 'nullable|url|max:255',
            'facilities' => 'array|nullable',
            'facilities.*' => 'exists:facilities,id',
        ]);

        // si hotel_id change, vérifier qu’il appartient au compte
        abort_unless(Hotel::where('id',$data['hotel_id'])->where('account_id',$accountId)->exists(), 403);

        $payload = Arr::except($data, ['facilities','image','video']);
        if ($request->hasFile('image')) {
            $payload['image_pending'] = $request->file('image')->store('rooms/images','pending');
        }
        if ($request->hasFile('video')) {
            $payload['video_pending'] = $request->file('video')->store('rooms/videos','pending');
        }

        // merge si une PENDING existe déjà
        $sub->upsertPending($room, $payload, 'update');

        // relations : direct (ou à modérer si tu préfères)
        if ($request->has('facilities')) $room->facilities()->sync($request->facilities);
        else $room->facilities()->detach();

        if ($request->has('save_and_media')) {
            return redirect()->route('media.index', [
                'type' => 'room',
                'key'  => $room->slug ?: $room->getKey(),
            ])->with('success', 'Modifications enregistrées. Gérer les médias.');
        }

        return back()->with('success', 'Modifications enregistrées. <a href="'.
            route('media.index',['type'=>'room','key'=>$room->slug ?: $room->getKey()]).
            '">Gérer les médias</a>');
    }


    public function toggleStatus(Request $request, Room $room) {
        $this->authorize($room);
        $request->validate(['status' => ['required','in:0,1']]);

        if ($request->boolean('status') && $room->has_pending_submission) {
            return response()->json([
                'success' => false,
                'message' => 'Validation admin en attente — publication impossible pour l’instant.'
            ], 422);
        }

        // (Optionnel) refuser totalement côté partners:
        // if ($request->boolean('status')) abort(403);

        $room->update(['status' => (bool)$request->status]);
        return response()->json(['success'=>true]);
    }
}
