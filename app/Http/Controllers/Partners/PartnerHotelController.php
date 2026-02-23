<?php

namespace App\Http\Controllers\Partners;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Category;
use App\Models\Country;
use App\Models\Facility;
use Illuminate\Http\Request;
use App\Services\SubmissionService;
use App\Models\ModerationStatus;
use App\Models\Hotel;
use App\Models\Review;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\Language;
use \App\Support\CurrentAccount;
use Illuminate\Support\Facades\Auth;

class PartnerHotelController extends Controller {

    protected function authorize(Hotel $hotel): void {
        $accountId = (int) app(CurrentAccount::class)->id();
        abort_if((int) $hotel->account_id !== $accountId, 403, 'Accès refusé.');
    }

    public function index(Request $request) {
        $accountId = app(CurrentAccount::class)->id();

        $status = $request->string('status')->toString(); // all|active|inactive
        $period = $request->string('period')->toString(); // last_month|last_7_days

        $q = Hotel::query()
            ->where('account_id', $accountId)
            ->with(['category','country'])
            ->withCount(['bookings','reviews','views','rooms'])
            // drapeau "a une soumission en attente"
            ->withExists(['submissions as has_pending_submission' => function ($s) {
                $s->whereHas('status', fn($st) => $st->where('slug','pending'));
            }]);

        if ($status === 'active')   $q->where('status', 1);
        if ($status === 'inactive') $q->where('status', 0);

        if ($period === 'last_month')  $q->where('created_at','>=',now()->subMonth());
        if ($period === 'last_7_days') $q->where('created_at','>=',now()->subDays(7));

        $hotels = $q->orderByDesc('created_at')->paginate(10)->withQueryString();

        // KPIs SCOPÉS AU COMPTE
        $total    = Hotel::where('account_id',$accountId)->count();
        $active   = Hotel::where('account_id',$accountId)->where('status',1)->count();
        $inactive = $total - $active;


        $stats = Review::whereHasMorph('reviewable', [Hotel::class], function ($q) use ($accountId) {
                $q->where('account_id', $accountId); // filtre côté hotels (pas dans reviews)
            })
            ->selectRaw('COALESCE(AVG(rating),0) AS avg_rating, COUNT(*) AS total_reviews')
            ->first();

        $averageRating = round((float) $stats->avg_rating, 2);
        $totalReviews  = (int) $stats->total_reviews;


        // (optionnel) listes pour le formulaire modal
        $categories = Category::where(fn($q) => $q->where('model','hotel')->orWhereNull('model'))->get();
        $countries  = Country::orderBy('name')->get();
        $facilities = Facility::where('status',1)->orderBy('name')->get();

        return view('backend.partners.hotels.index', compact(
            'hotels','total','active','inactive','categories','countries','facilities', 'averageRating', 'totalReviews'
        ));
    }

    public function create() {
        $categories = Category::where(fn($q)=>$q->where('model','hotel')->orWhereNull('model'))->get();
        $countries  = Country::orderBy('name')->get();
        $facilities = Facility::where('status',1)->orderBy('name')->get();
        $accounts = Account::query()
        ->where('status',1)
        ->whereHas('modules', fn($m)=>$m->where('slug','hotel'))
        ->orderBy('name')
        ->get();

        return view('backend.partners.hotels.create', compact('categories','countries','facilities', 'accounts'));
    }

    public function store(Request $request, SubmissionService $sub)  {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'country_id' => 'nullable|exists:countries,id',
            'category_id' => 'nullable|exists:categories,id',
            'free_rooms' => 'nullable|integer|min:0',
            'total_rooms' => 'nullable|integer|min:0',
            'type' => 'nullable|string|in:Standard,Luxe,Eco',
            'video' => 'nullable|file|mimes:mp4,mov,avi,wmv|max:51200',
            'video_url' => 'nullable|url|max:255',
            'info' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'image' => 'nullable|image|max:10240',
            'description' => 'nullable|string|max:3000',
            'facilities'  => 'array|nullable',
            'facilities.*'=> 'exists:facilities,id',
        ]);

    
        // 1) Crée le record principal (inactive)
        $hotel = new Hotel();
        $hotel->fill(collect($data)->except(['facilities','image','video'])->toArray());
        $hotel->account_id = app(CurrentAccount::class)->id();
        $hotel->status = 0;

        // On ne met PAS d'image/vidéo visibles ici
        $hotel->save();

        // Relations OK (pas visibles si l’hôtel est inactif de toute façon)
        $hotel->facilities()->sync($request->input('facilities', []));

        // 2) Soumission "create" : version scalaires seules
        $payload = Arr::except($data, ['facilities','image','video']);

        // Si fichiers présents => les mettre en pending et ajouter *pending* au payload
        if ($request->hasFile('image')) {
            $tmp = $request->file('image')->store('hotels/images', 'pending');
            $payload['image_pending'] = $tmp; // string
        }

        if ($request->hasFile('video')) {
            $tmp = $request->file('video')->store('hotels/videos', 'pending');
            $payload['video_pending'] = $tmp; // string
        }

        $sub->submit($hotel, $payload, 'create');
        return redirect()->route('media.index', ['type' => 'hotel','key'  => $hotel->slug ?: $hotel->getKey(),])
            ->with('success', 'Hôtel créé. En attente de validation... Veuillez maintenant ajouter des images.');
    }

    public function edit(Hotel $hotel) {
        abort_unless($hotel->account_id === app(CurrentAccount::class)->id(), 403);
        $categories = Category::where(fn($q)=>$q->where('model','hotel')->orWhereNull('model'))->get();
        $countries  = Country::orderBy('name')->get();
        $facilities = Facility::where('status',1)->orderBy('name')->get();
        $accounts = Account::query()
        ->where('status',1)
        ->whereHas('modules', fn($m)=>$m->where('slug','artisan'))
        ->orderBy('name')
        ->get();
        return view('backend.partners.hotels.edit', compact('hotel','countries','categories','facilities', 'accounts'));
    }

    public function update(Request $request, Hotel $hotel, SubmissionService $sub) {
        abort_unless($hotel->account_id === app(CurrentAccount::class)->id(), 403);

        // ❗ Bloque s'il existe déjà au moins une soumission "pending"
        // $hasPending = $hotel->submissions()
        //     ->whereHas('status', fn($q) => $q->where('slug','pending'))
        //     ->exists();

        // if ($hasPending) {
        //     return back()->with('warning', 'Une demande est déjà en attente pour cet hôtel.');
        // }

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'country_id' => 'nullable|exists:countries,id',
            'category_id' => 'nullable|exists:categories,id',
            'free_rooms' => 'nullable|integer|min:0',
            'total_rooms' => 'nullable|integer|min:0',
            'type' => 'nullable|string|in:Standard,Luxe,Eco',
            'video' => 'nullable|file|mimes:mp4,mov,avi,wmv|max:51200',
            'video_url' => 'nullable|url|max:255',
            'info' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'image' => 'nullable|image|max:10240',
            'description' => 'nullable|string|max:3000',
            'facilities'  => 'array|nullable',
            'facilities.*'=> 'exists:facilities,id',
        ]);

        $payload = Arr::except($data, ['facilities','image','video']);

        if ($request->hasFile('image')) {
            $payload['image_pending'] = $request->file('image')->store('hotels/images', 'pending');
        }
        if ($request->hasFile('video')) {
            $payload['video_pending'] = $request->file('video')->store('hotels/videos', 'pending');
        }

        // ❗ utiliser $payload (et pas $data)
        $sub->upsertPending($hotel, $payload, 'update');

        // Relations (si non modérées)
        if ($request->has('facilities')) {
            $hotel->facilities()->sync($request->input('facilities', []));
        } else {
            $hotel->facilities()->detach();
        }

        // Redirections unifiées
        if ($request->has('save_and_media')) {
            return redirect()->route('media.index', [
                'type' => 'hotel',
                'key'  => $hotel->slug ?: $hotel->getKey(),
            ])->with('success', 'Modifications enregistrées. Gérer les médias.');
        }

        return back()->with('success_html', 'Modifications enregistrées. <a href="'.
            route('media.index', ['type'=>'hotel','key'=>$hotel->slug ?: $hotel->getKey()]).
            '">Gérer les médias</a>');
    }


     public function toggleStatus(Request $request, Hotel $hotel) {
        $this->authorize($hotel);
        $request->validate(['status' => ['required','in:0,1']]);

        if ($request->boolean('status') && $hotel->has_pending_submission) {
            return response()->json([
                'success' => false,
                'error' => 'Validation admin en attente — publication impossible pour l’instant.'
            ], 422);
        }

        // (Optionnel) refuser totalement côté partners:
        // if ($request->boolean('status')) abort(403);

        $hotel->update(['status' => (bool)$request->status]);
        return response()->json(['success'=>true]);
    }
}
