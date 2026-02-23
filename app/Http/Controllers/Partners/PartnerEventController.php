<?php

namespace App\Http\Controllers\Partners;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Module;
use Illuminate\Support\Str;
use App\Support\CurrentAccount;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use App\Models\{Category, ContentSubmission, Outing, Guide, GuidePlace, ModerationStatus, Site};
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Event;
use Illuminate\Support\Facades\Schema;
use App\Services\SubmissionService;
use Illuminate\Http\UploadedFile;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PartnerEventController extends Controller {

    public function dashboard(Request $request, CurrentAccount $ctx) {
        $account = $ctx->get();
        abort_if(!$account, 403, 'Aucun compte courant.');

        $now = Carbon::now();

        // ====== Base Events (compte courant) ======
        $base = Event::query()->where('account_id', $account->id);

        $metrics = [
            'events_total'    => (clone $base)->count(),
            'events_upcoming' => (clone $base)->where('start_date', '>=', $now)->count(),
            'events_live'     => (clone $base)->where('start_date', '<=', $now)->where('end_date', '>=', $now)->count(),
            'events_past'     => (clone $base)->where('end_date', '<', $now)->count(),
            'published'       => null,
            'pending'         => null,
            'drafts'          => null,
        ];

        // Si colonne de modération présente, on calcule
        if (Schema::hasColumn('events', 'moderation_status')) {
            // 0=draft, 1=pending, 2=approved, 3=rejected, 4=archived (proposé plus tôt)
            $metrics['drafts']    = (clone $base)->where('moderation_status', 0)->count();
            $metrics['pending']   = (clone $base)->where('moderation_status', 1)->count();
            $metrics['published'] = (clone $base)->where('moderation_status', 2)->count();
        }

        // ====== Listes ======
        $nextEvents = (clone $base)
            ->where('end_date', '>=', $now)
            ->orderBy('start_date')
            ->limit(6)
            ->get(['id','name','start_date','end_date','location','status','slug']);

        // ====== Billetterie (facultatif tant que pas migré) ======
        $hasOrders    = Schema::hasTable('orders')      && Schema::hasColumn('orders', 'event_id');
        $hasAttendees = Schema::hasTable('attendees')   && Schema::hasColumn('attendees', 'event_id');
        $hasCheckins  = Schema::hasTable('checkins')    && Schema::hasColumn('checkins', 'attendee_id');

        $from30 = $now->copy()->subDays(30)->toDateTimeString();

        $sales = [
            'revenue30'     => $hasOrders
                ? (float) DB::table('orders')
                    ->where('account_id', $account->id)
                    ->whereNotNull('event_id')
                    ->where('payment_status', 'paid')
                    ->where('created_at', '>=', $from30)
                    ->sum('total')
                : null,
            'orders30'      => $hasOrders
                ? (int) DB::table('orders')
                    ->where('account_id', $account->id)
                    ->whereNotNull('event_id')
                    ->where('payment_status', 'paid')
                    ->where('created_at', '>=', $from30)
                    ->count()
                : null,
            'attendees30'   => $hasAttendees
                ? (int) DB::table('attendees')
                    ->where('event_id', '>', 0)
                    ->where('created_at', '>=', $from30)
                    ->count()
                : null,
            'checkinsToday' => ($hasAttendees && $hasCheckins)
                ? (int) DB::table('checkins')
                    ->whereDate('scanned_at', Carbon::today())
                    ->count()
                : null,
        ];


        $recentOrders = $hasOrders
            ? DB::table('orders')
                ->where('account_id', $account->id)
                ->whereNotNull('event_id')
                ->orderByDesc('created_at')
                ->limit(6)
                ->get(['id','event_id','buyer_email','total','currency','payment_status','created_at'])
            : collect();

        return view('backend.event.dashboard', [
            'account'     => $account,
            'now'         => $now,
            'metrics'     => $metrics,
            'nextEvents'  => $nextEvents,
            'sales'       => $sales,
            'recentOrders'=> $recentOrders,
            'flags'       => [
                'hasOrders'    => $hasOrders,
                'hasAttendees' => $hasAttendees,
                'hasCheckins'  => $hasCheckins,
            ],
        ]);
    }


     // Helpers

    private function accountId(): int {
        return (int) app(CurrentAccount::class)->id();
    }
    private function inAccount(Event $event): void {
        abort_unless((int) $event->account_id === $this->accountId(), 403);
    }

    private function baseQuery() {
        return Event::query()->where('account_id', $this->accountId());
    }

    private function validatedEvent(Request $request, bool $isCreate = true): array{
        return $request->validate([
            'name'        => ['required','string','max:255'],
            'description' => ['required','string'],
            'start_date'  => ['required','date'],
            'end_date'    => ['required','date','after_or_equal:start_date'],
            'location'    => ['nullable','string','max:255'],
            'latitude'    => ['nullable','numeric','between:-90,90'],
            'longitude'   => ['nullable','numeric','between:-180,180'],
            'map_url'     => ['nullable','url'],
            'category_id' => ['nullable','integer','exists:categories,id'],
            'image'       => [$isCreate ? 'nullable' : 'nullable','image','mimes:jpg,jpeg,png,webp','max:4096'],
        ]);
    }

    private function suggestSlug(string $name, ?int $ignoreId = null): string {
        $base = Str::slug($name) ?: 'event';
        $slug = $base;
        $i = 1;

        while (
            Event::query()
                ->where('account_id',$this->accountId())
                ->when($ignoreId, fn($q)=>$q->where('id','!=',$ignoreId))
                ->where('slug',$slug)
                ->exists()
        ) {
            $slug = $base.'-'.$i++;
        }
        return $slug;
    }

    private function storePendingUpload(UploadedFile $file, string $folder): string{
        $ext  = strtolower($file->getClientOriginalExtension() ?: $file->extension() ?: 'jpg');
        $name = Str::ulid().'.'.$ext;
        $path = trim($folder,'/').'/'.$name; // ex: events/images/01J...
        Storage::disk('pending')->putFileAs($folder, $file, $name);
        return $path; // ← relative path attendu par SubmissionService (image_pending)
    }


    // events
    public function index(Request $request) {
        $q = $this->baseQuery();

        if ($search = (string) $request->string('q')) {
            $q->where(function ($qq) use ($search) {
                $qq->where('name', 'like', "%{$search}%")
                   ->orWhere('location', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $status = $request->string('status')->toString();
            if ($status === 'published')   $q->where('status', 1);
            if ($status === 'draft')       $q->where('status', 0);
            if ($status === 'pending' && Schema::hasColumn('events','moderation_status')) {
                $q->where('moderation_status', 1);
            }
        }

        $now          = Carbon::now();
        $totalEvents  = (clone $this->baseQuery())->count();
        $upcoming     = (clone $this->baseQuery())->where('start_date','>', $now)->count();
        $past         = (clone $this->baseQuery())->where('end_date','<',  $now)->count();
        $liveNow      = (clone $this->baseQuery())->where('start_date','<=',$now)->where('end_date','>=',$now)->count();

        $events = $q
            ->withCount([
                'submissions as pending_count' => function($q){
                $q->whereHas('status', fn($qq)=>$qq->where('slug','pending'));
                }
            ])->latest('start_date')->paginate(12)->withQueryString();

        // $events = $q->latest('start_date')->paginate(12)->withQueryString();

        return view('backend.event.events.index', [
            'events'         => $events,
            'totalEvents'    => $totalEvents,
            'upcomingEvents' => $upcoming,
            'pastEvents'     => $past,
            'liveNow'        => $liveNow,
        ]);
    }

    public function create() {
        $categories = Category::query()
            ->where('status', 1)
            ->where(fn($q) => $q->whereIn('model', ['event','Event'])->orWhereNull('model'))
            ->orderBy('name')
            ->get();

        return view('backend.event.events.create', compact('categories'));
    }

    public function store(Request $request, SubmissionService $sub) {
        $data = $this->validatedEvent($request, true);

        // caté dispo ?
        $categories = Category::query()
            ->where('status', 1)
            ->where(fn($q) => $q->whereIn('model', ['event','Event'])->orWhereNull('model'))
            ->pluck('id')->all();

        if (!empty($data['category_id']) && !in_array((int)$data['category_id'], $categories, true)) {
            return back()->withErrors(['category_id'=>'Catégorie invalide pour les événements.'])->withInput();
        }


        // 1) Création en brouillon avec slug OBLIGATOIRE & unique (scopé compte)
        $event = new Event();
        $event->account_id   = $this->accountId();
        $event->name         = $data['name'];
        $event->description  = $data['description'];
        $event->start_date   = $data['start_date'];
        $event->end_date     = $data['end_date'];
        $event->location     = $data['location'] ?? null;
        $event->latitude     = $data['latitude'] ?? null;
        $event->longitude    = $data['longitude'] ?? null;
        $event->map_url      = $data['map_url'] ?? null;
        $event->category_id  = $data['category_id'] ?? null;
        // $event->status       = 0; // brouillon
        $event->status = \App\Models\Event::STATUS_INACTIVE;

        if (Schema::hasColumn('events','language_id') && !$event->language_id) {
            $event->language_id = 1;
        }
        if (Schema::hasColumn('events','moderation_status')) {
            $event->moderation_status = 1; // pending
        }
        if (Schema::hasColumn('events','created_by')) {
            $event->created_by = Auth::id();
        }

        $event->slug = $this->suggestSlug($data['name']); // slug requis
        $event->save();

        // 2) Image -> pending + payload
        $changes = [
            'name'        => $data['name'],
            'description' => $data['description'],
            'start_date'  => $data['start_date'],
            'end_date'    => $data['end_date'],
            'location'    => $data['location'] ?? null,
            'latitude'    => $data['latitude'] ?? null,
            'longitude'   => $data['longitude'] ?? null,
            'map_url'     => $data['map_url'] ?? null,
            'category_id' => $data['category_id'] ?? null,
        ];

        if ($request->hasFile('image')) {
            $changes['image_pending'] = $this->storePendingUpload($request->file('image'), 'events/images');
        }

        // 3) Soumettre MAJ contenu + publication
        $sub->submit($event, $changes, 'create', $request->input('comment'));

        return redirect()->route('partners.event.events.index')
            ->with('success','Événement créé en brouillon. Demandes de mise à jour & publication envoyées.');
    }

    public function edit(Event $event) {
        $this->inAccount($event);

        $categories = Category::query()
            ->where('status', 1)
            ->where(fn($q) => $q->whereIn('model', ['event','Event'])->orWhereNull('model'))
            ->orderBy('name')
            ->get();

        return view('backend.event.events.edit', compact('event','categories'));
    }

    public function update(Request $request, Event $event, SubmissionService $sub) {
        $this->inAccount($event);
        $data = $this->validatedEvent($request, false);

        // vérifier catégorie autorisée
        $categories = Category::query()
            ->where('status', 1)
            ->where(fn($q) => $q->whereIn('model', ['event','Event'])->orWhereNull('model'))
            ->pluck('id')->all();
        if (!empty($data['category_id']) && !in_array((int)$data['category_id'], $categories, true)) {
            return back()->withErrors(['category_id'=>'Catégorie invalide pour les événements.'])->withInput();
        }

        $changes = [
            'name'        => $data['name'],
            'description' => $data['description'],
            'start_date'  => $data['start_date'],
            'end_date'    => $data['end_date'],
            'location'    => $data['location'] ?? null,
            'latitude'    => $data['latitude'] ?? null,
            'longitude'   => $data['longitude'] ?? null,
            'map_url'     => $data['map_url'] ?? null,
            'category_id' => $data['category_id'] ?? null,
        ];

        // NE PAS modifier le slug s’il existe déjà
        if (!$event->slug) {
            $changes['slug'] = $this->suggestSlug($data['name'], $event->id);
        }

        if ($request->hasFile('image')) {
            $changes['image_pending'] = $this->storePendingUpload($request->file('image'), 'events/images');
        }

        $sub->upsertPending($event, $changes, 'update');

        return back()->with('success','Modifications soumises pour validation.');
    }

    public function destroy(Event $event, SubmissionService $sub) {
        $this->inAccount($event);
        $sub->submit($event, [], 'delete', request('comment'));
        return redirect()->route('partners.event.events.index')->with('success','Demande de suppression envoyée.');
    }



    // Actions
    public function duplicate(Event $event){
        $this->inAccount($event);

        $clone = $event->replicate(['slug','published_at','cancelled_at','approved_by','created_by','updated_by','image','video']);
        $clone->name    = $event->name.' (copie)';
        $clone->status  = 0;
        if (Schema::hasColumn('events','moderation_status')) $clone->moderation_status = 0;
        if (Schema::hasColumn('events','created_by')) $clone->created_by = Auth::id();
        $clone->slug    = $this->suggestSlug($clone->name); // slug obligatoire
        $clone->save();

        return redirect()->route('partners.event.events.edit', $clone->id)
            ->with('success','Copie créée en brouillon. Vous pouvez soumettre à validation.');
    }

    private function hasPending(Event $event): bool {
        return $event->submissions()->whereHas('status', fn($q)=>$q->where('slug','pending'))->exists();
    }

    public function publish(Event $event, SubmissionService $sub) {
        $this->inAccount($event);
        if ($this->hasPending($event)) return back()->with('warning','Action indisponible : une demande est déjà en attente.');
        $sub->submit($event, ['status'=>1], 'publish', request('comment'));
        return back()->with('success','Demande de publication envoyée.');
    }

    public function unpublish(Event $event, SubmissionService $sub) {
        $this->inAccount($event);
        if ($this->hasPending($event)) return back()->with('warning','Action indisponible : une demande est déjà en attente.');
        $sub->submit($event, ['status'=>0], 'unpublish', request('comment'));
        return back()->with('success','Demande de dépublication envoyée.');
    }



    // public function publish(Event $event, SubmissionService $sub) {
    //     $this->inAccount($event);
    //     $sub->submit($event, ['status'=>1], 'publish', request('comment'));
    //     return back()->with('success','Demande de publication envoyée.');
    // }
    // public function unpublish(Event $event, SubmissionService $sub) {
    //     $this->inAccount($event);
    //     $sub->submit($event, ['status'=>0], 'unpublish', request('comment'));
    //     return back()->with('success','Demande de dépublication envoyée.');
    // }
    public function archive(Event $event, SubmissionService $sub) {
        $this->inAccount($event);
        $changes = ['status'=>0];
        if (Schema::hasColumn('events','moderation_status')) {
            $changes['moderation_status'] = 4; // archived
        }
        $sub->submit($event, $changes, 'unpublish', request('comment'));
        return back()->with('success','Demande d’archivage envoyée.');
    }
    public function unarchive(Event $event, SubmissionService $sub) {
        $this->inAccount($event);
        $changes = ['status'=>1];
        if (Schema::hasColumn('events','moderation_status')) {
            $changes['moderation_status'] = 2; // approved/published
        }
        $sub->submit($event, $changes, 'publish', request('comment'));
        return back()->with('success','Demande de désarchivage envoyée.');
    }
    public function cancel(Request $request, Event $event, SubmissionService $sub) {
        $this->inAccount($event);
        $request->validate([
            'reason'  => 'nullable|string|max:500',
            'comment' => 'nullable|string|max:1000',
        ]);

        $changes = ['status'=>0];
        if (Schema::hasColumn('events','cancelled_at'))   $changes['cancelled_at']   = now();
        if (Schema::hasColumn('events','cancel_reason'))  $changes['cancel_reason']  = $request->input('reason');

        $sub->submit($event, $changes, 'update', $request->input('comment'));

        return back()->with('success','Demande d’annulation envoyée.');
    }
    public function calendar(Request $request) {
        $start = Carbon::parse($request->input('start', now()->startOfMonth()));
        $end   = Carbon::parse($request->input('end',   now()->endOfMonth()));

        $events = $this->baseQuery()
            ->whereDate('end_date', '>=', $start->toDateString())
            ->whereDate('start_date', '<=', $end->toDateString())
            ->orderBy('start_date')
            ->get(['id','name','start_date','end_date','location','status']);

        return view('backend.event.events.calendar', compact('events','start','end'));
    }


    public function export(Request $request): StreamedResponse {
        $q = $this->baseQuery();

        // filtres optionnels
        if ($search = (string) $request->string('q')) {
            $q->where(fn($qq) => $qq->where('name','like',"%{$search}%")
                                    ->orWhere('location','like',"%{$search}%"));
        }
        if ($request->filled('status')) {
            $status = $request->string('status')->toString();
            if ($status === 'published') $q->where('status',1);
            if ($status === 'draft')     $q->where('status',0);
        }
        if ($request->filled('start')) {
            $start = Carbon::parse($request->input('start'))->startOfDay();
            $q->where('start_date','>=',$start);
        }
        if ($request->filled('end')) {
            $end = Carbon::parse($request->input('end'))->endOfDay();
            $q->where('end_date','<=',$end);
        }

        $file = 'events-export-'.now()->format('Ymd_His').'.csv';
        $q->orderBy('start_date');

        return response()->streamDownload(function () use ($q) {
            $out = fopen('php://output', 'w');
            echo chr(0xEF).chr(0xBB).chr(0xBF); // BOM UTF-8 (Excel)
            fputcsv($out, ['ID','Nom','Début','Fin','Lieu','Statut']);
            $q->chunk(500, function ($rows) use ($out) {
                foreach ($rows as $e) {
                    fputcsv($out, [$e->id,$e->name,$e->start_date,$e->end_date,$e->location,$e->status ? 'Actif' : 'Inactif']);
                }
            });
            fclose($out);
        }, $file, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }





        //// Profile + Settings
        public function editProfile() {
            $user = Auth::user();
            return view('backend.event.profile', compact('user'));
        }
        public function updateProfile(Request $r) {
            $user = Auth::user();

            $data = $r->validate([
                'firstname' => ['required','string','max:120'],
                'lastname'  => ['required','string','max:120'],
                'phone'     => ['nullable','string','max:60'],
                'whatsapp'  => ['nullable','string','max:60'],
                'email'     => ['nullable','email','max:190', Rule::unique('users','email')->ignore($user->id)],
            ]);

            // 1) Mise à jour User
            $user->fill($data)->save();
            return back()->with('success', 'Profil mis à jour.');
        }

        public function editSettings() {
            $user = Auth::user();
            return view('backend.event.settings', compact('user'));
        }
        public function updateSettings(Request $r) {
            $r->validate([
                'current_password' => ['required','current_password'],
                'password'         => ['required','string','min:8','confirmed','different:current_password'],
            ]);
            $r->user()->update(['password' => Hash::make($r->input('password'))]);
            return back()->with('success', 'Mot de passe mis à jour.');
        }

    }
