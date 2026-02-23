<?php

namespace App\Http\Controllers\Partners;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use App\Models\ContentSubmission;
use App\Models\Hotel;
use App\Models\ModerationStatus;
use App\Models\Order;
use App\Models\Product;
use App\Models\Room;
use App\Services\SubmissionService;
use App\Support\CurrentAccount;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


class PartnerSubmissionController extends Controller {

    public function index(Request $request) {
        $accountId = app(CurrentAccount::class)->id();
        $subs = ContentSubmission::with(['model','status'])
            ->where('account_id', $accountId)
            // option: ne montrer que les propres demandes de l’utilisateur
            ->where('user_id', Auth::id())
            ->when($request->filled('status'), function ($q) use ($request) {
                $statusId = ModerationStatus::idFor((string)$request->string('status'));
                if ($statusId) $q->where('status_id', $statusId);
            })
            ->when($request->filled('type'), function ($q) use ($request) {

                $map = [

                    'product'  => \App\Models\Product::class,
                    'order'    => \App\Models\Order::class,

                ];

                if ($request->filled('type')) {
                    $type = strtolower($request->string('type')->toString()); // cast en string
                    $cls  = $map[$type] ?? null;
                    if ($cls) {
                        $q->where('model_type', $cls);
                    }
                }
            })
            ->latest()->paginate(10)->withQueryString();
        return view('backend.partners.submissions.index', compact('subs'));
    }

    public function show(ContentSubmission $submission) {
        abort_unless((int)$submission->account_id === (int)app(CurrentAccount::class)->id(), 403);
        abort_unless((int)$submission->user_id === (int)Auth::id(), 403); // limiter à l’auteur
        $submission->load(['model','status']);
        return view('backend.partners.submissions.show', compact('submission'));
    }



    public function orderRequest(Request $request, Order $order, SubmissionService $sub) {
        return $this->handle($request, $order, $sub);
    }

    public function productRequest(Request $request, Product $product, SubmissionService $sub) {
        return $this->handle($request, $product, $sub);
    }

    public function placeRequest(Request $request, string $type, int $id, SubmissionService $sub) {
        $map = [

        ];
        $cls = $map[$type] ?? null;
        abort_if(!$cls, 404);

        /** @var \Illuminate\Database\Eloquent\Model $model */
        $model = $cls::query()->findOrFail($id);

        // Sécurité compte + auteur
        $accountId = app(\App\Support\CurrentAccount::class)->id();
        $modelAccountId = (int) data_get($model, 'account_id');
        abort_unless($modelAccountId === (int) $accountId, 403);


        $action = $request->validate([
            'action'  => 'required|string|in:publish,unpublish,activate,deactivate,update,delete',
            'comment' => 'nullable|string|max:1000',
        ])['action'];

        $mapActions = [
            'publish'    => ['operation' => 'publish',    'changes' => []],   // -> status = 1
            'activate'   => ['operation' => 'activate',   'changes' => []],   // alias publish
            'unpublish'  => ['operation' => 'unpublish',  'changes' => []],   // -> status = 0
            'deactivate' => ['operation' => 'deactivate', 'changes' => []],   // alias unpublish
            'update'     => ['operation' => 'update',     'changes' => []],   // diffs via upsertPending
            'delete'     => ['operation' => 'delete',     'changes' => []],
        ];

        [$op, $changes] = [$mapActions[$action]['operation'], $mapActions[$action]['changes']];

        // Anti-spam : une pending à la fois
        $hasPending = $model->submissions()
            ->whereHas('status', fn($q)=>$q->where('slug','pending'))
            ->exists();
        if ($hasPending) {
            return back()->with('warning','Une demande est déjà en attente.');
        }
        $sub->submit($model, $changes, $op, $request->input('comment'));

        return back()->with('success','Demande envoyée pour validation.');
    }

    /**
     * Logique commune (auth compte courant, anti-spam, mapping des actions, création submission)
     */
    private function handle(Request $request, Model $model, SubmissionService $sub) {
        // 1) Sécurité compte courant
        $accountId = app(CurrentAccount::class)->id();
        $modelAccountId = (int) data_get($model, 'account_id');
        $modelAccountId = $modelAccountId ?: (int) data_get($model, 'hotel.account_id'); // Room via Hotel
        abort_unless($modelAccountId === (int) $accountId, 403);

        // 2) Validation action/comment
        $action = $request->validate([
            'action'  => 'required|string|in:publish,unpublish,activate,deactivate,delete',
            'comment' => 'nullable|string|max:1000',
        ])['action'];

        // 3) Anti-spam : une soumission "pending" à la fois
        $hasPending = $model->submissions()
            ->whereHas('status', fn($q) => $q->where('slug','pending'))
            ->exists();
        if ($hasPending) {
            return back()->with('warning','Une demande est déjà en attente.');
        }

        // 4) Mapping action -> operation + changes
        $map = [
            'publish'    => ['operation' => 'publish',    'changes' => ['status' => 1]],
            'unpublish'  => ['operation' => 'unpublish',  'changes' => ['status' => 0]],
            'activate'   => ['operation' => 'activate',   'changes' => ['status' => 1]],
            'deactivate' => ['operation' => 'deactivate', 'changes' => ['status' => 0]],
            'delete'     => ['operation' => 'delete',     'changes' => []],
        ];
        [$operation, $changes] = [$map[$action]['operation'], $map[$action]['changes']];

        // 5) Créer la soumission (ne touche pas le modèle principal)
        $sub->submit($model, $changes, $operation, $request->input('comment') ?? null);

        return back()->with('success','Demande envoyée pour validation.');
    }


}
