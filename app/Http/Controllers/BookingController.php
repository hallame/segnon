<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\HasFilters;
use App\Models\Guide;
use App\Models\GuidePlace;
use App\Models\Outing;
use App\Models\Site;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class BookingController extends Controller {

    use HasFilters;

    /** Labels utiles (affichage) */
    private array $statusLabels = [
        Booking::STATUS_PENDING   => 'En attente',
        Booking::STATUS_CONFIRMED => 'Confirmée',
        Booking::STATUS_CANCELLED => 'Annulée',
        Booking::STATUS_COMPLETED => 'Terminée',
    ];
    private array $paymentLabels = [
        Booking::PAY_UNPAID         => 'Non payée',
        Booking::PAY_AWAITING_VERIF => 'Vérification',
        Booking::PAY_VERIFIED       => 'Vérifiée',
        Booking::PAY_REJECTED       => 'Rejetée',
    ];

    public function index(Request $r) {
        $q            = trim($r->input('q',''));
        $status       = $r->input('status');         // 0..3
        $pay          = $r->input('payment_status'); // 0..3
        $from         = $r->input('from');           // YYYY-MM-DD (check_in >=)
        $to           = $r->input('to');             // YYYY-MM-DD (check_out <=)
        $source       = $r->input('source');         // web/mobile/admin
        $isGroup      = $r->input('group');          // '1' ou '0' (optionnel)

        $query = Booking::query()
            ->with(['client'])
            ->with(['client', 'bookable' => function (MorphTo $m) {
                $m->morphWith([
                    \App\Models\Site::class    => [],
                    \App\Models\Circuit::class => [],
                    \App\Models\Room::class    => [],
                    \App\Models\Event::class   => [],
                ]);
            }])
            ->when($q, function($qq) use ($q){
                $qq->where(function($sub) use ($q){
                    $sub->where('reference','like',"%$q%")
                        ->orWhere('payment_reference','like',"%$q%")
                        ->orWhereHas('client', fn($c)=>$c->where('firstname','like',"%$q%")->orWhere('lastname','like',"%$q%")->orWhere('email','like',"%$q%"));
                });
            })
            ->when($status !== null && $status !== '', fn($qq)=>$qq->where('status',(int)$status))
            ->when($pay !== null && $pay !== '',     fn($qq)=>$qq->where('payment_status',(int)$pay))
            ->when($from, fn($qq)=>$qq->whereDate('check_in','>=',$from))
            ->when($to,   fn($qq)=>$qq->whereDate('check_out','<=',$to))
            ->when($source, fn($qq)=>$qq->where('source',$source))
            ->when($isGroup !== null && $isGroup !== '', fn($qq)=>$qq->where('is_group',(bool)$isGroup))
            ->orderByDesc('created_at');


        $bookings = $query->latest()->paginate(20)->withQueryString();

        // KPIs rapides
        $kpis = [
            'total'      => Booking::count(),
            'thisMonth'  => Booking::whereBetween('created_at',[now()->startOfMonth(), now()->endOfMonth()])->count(),
            'pending'    => Booking::where('status', Booking::STATUS_PENDING)->count(),
            'confirmed'  => Booking::where('status', Booking::STATUS_CONFIRMED)->count(),
            'completed'  => Booking::where('status', Booking::STATUS_COMPLETED)->count(),
            'cancelled'  => Booking::where('status', Booking::STATUS_CANCELLED)->count(),
            'unpaid'     => Booking::where('payment_status', Booking::PAY_UNPAID)->count(),
            'verified'   => Booking::where('payment_status', Booking::PAY_VERIFIED)->count(),
            'revenue'    => Booking::where('payment_status', Booking::PAY_VERIFIED)->sum('amount'),
        ];

        return view('backend.admin.bookings.index', [
            'bookings'     => $bookings,
            'kpis'         => $kpis,
            'statusLabels' => $this->statusLabels,
            'paymentLabels'=> $this->paymentLabels,
            'filters'      => compact('q','status','pay','from','to','source','isGroup'),
        ]);
    }



    // public function show(Booking $booking) {
    //     $booking->load([
    //         'client',
    //         'days',
    //         'bookable' => function (MorphTo $morphTo) {
    //             $morphTo->morphWith([
    //                 Room::class => ['hotel'], // => eager-load de l’hôtel
    //             ]);
    //         },
    //     ]);

    //     return view('backend.admin.bookings.show', [
    //         'b'            => $booking,
    //         'statusLabels' => $this->statusLabels,
    //         'paymentLabels'=> $this->paymentLabels,
    //     ]);
    // }



    /** Transition statut RÉSERVATION */
    public function updateStatus(Request $r, Booking $booking) {
        $to = (int)$r->validate([
            'status' => ['required', Rule::in(array_keys($this->statusLabels))],
            'note'   => ['nullable','string','max:500'],
        ])['status'];

        $from = (int)$booking->status;

        $A = Booking::class;
        $allowed = [
            $A::STATUS_PENDING   => [$A::STATUS_CONFIRMED, $A::STATUS_CANCELLED],
            $A::STATUS_CONFIRMED => [$A::STATUS_COMPLETED, $A::STATUS_CANCELLED],
            $A::STATUS_CANCELLED => [],       // terminal
            $A::STATUS_COMPLETED => [],       // terminal
        ];
        if (!in_array($to, $allowed[$from] ?? [], true)) {
            return back()->with('warning', "Transition non autorisée: {$this->label($from)} → {$this->label($to)}");
        }

        DB::transaction(function () use ($booking, $from, $to, $r) {
            // Libérer les jours si ANNULÉ
            if ($to === Booking::STATUS_CANCELLED && $from !== Booking::STATUS_CANCELLED) {
                $booking->days()->delete();
                $booking->cancellation_reason = $r->input('note');
            }
            $booking->status = $to;
            $booking->note   = $this->appendNote($booking->note, "Status: {$this->label($from)} → {$this->label($to)}", $r->input('note'));
            $booking->save();
        });

        return back()->with('success','Statut de réservation mis à jour.');
    }

    /** Transition statut PAIEMENT */
    public function updatePayment(Request $r, Booking $booking) {
        $to = (int)$r->validate([
            'payment_status' => ['required', Rule::in(array_keys($this->paymentLabels))],
            'payment_due_at' => ['nullable','date'],
            'payment_reference' => ['nullable','string','max:120'],
            'note'           => ['nullable','string','max:500'],
        ])['payment_status'];

        $from = (int)$booking->payment_status;

        $P = Booking::class;
        $allowed = [
            $P::PAY_UNPAID         => [$P::PAY_AWAITING_VERIF, $P::PAY_VERIFIED, $P::PAY_REJECTED],
            $P::PAY_AWAITING_VERIF => [$P::PAY_VERIFIED, $P::PAY_REJECTED, $P::PAY_UNPAID],
            $P::PAY_VERIFIED       => [$P::PAY_REJECTED], // (optionnel) rollback limité
            $P::PAY_REJECTED       => [$P::PAY_AWAITING_VERIF, $P::PAY_VERIFIED, $P::PAY_UNPAID],
        ];
        if (!in_array($to, $allowed[$from] ?? [], true)) {
            return back()->with('warning', "Transition paiement non autorisée: {$this->plabel($from)} → {$this->plabel($to)}");
        }

        $booking->update([
            'payment_status'   => $to,
            'payment_due_at'   => $r->input('payment_due_at') ?: $booking->payment_due_at,
            'payment_reference'=> $r->input('payment_reference') ?: $booking->payment_reference,
            'note'             => $this->appendNote($booking->note, "Payment: {$this->plabel($from)} → {$this->plabel($to)}", $r->input('note')),
        ]);

        return back()->with('success','Statut de paiement mis à jour.');
    }

    /** Upload reçu (image/pdf) */
    public function uploadReceipt(Request $r, Booking $booking) {
        $data = $r->validate([
            'receipt' => ['required','file','mimes:jpg,jpeg,png,webp,pdf','max:5120'],
        ]);

        // Supprime l’ancien si présent
        if ($booking->payment_receipt_path) {
            Storage::disk('public')->delete($booking->payment_receipt_path);
        }

        $path = $r->file('receipt')->store('receipts', 'public');
        $booking->update(['payment_receipt_path' => $path]);

        return back()->with('success','Reçu enregistré.');
    }

    /** Supprimer le reçu */
    public function deleteReceipt(Booking $booking) {
        if ($booking->payment_receipt_path) {
            Storage::disk('public')->delete($booking->payment_receipt_path);
            $booking->update(['payment_receipt_path' => null]);
        }
        return back()->with('success','Reçu supprimé.');
    }

    /** Suppression de la réservation */
    public function destroy(Booking $booking) {
        if (in_array((int)$booking->status, [Booking::STATUS_CONFIRMED, Booking::STATUS_COMPLETED], true)) {
            return back()->with('warning','Réservation confirmée/terminée : suppression déconseillée.');
        }

        try {
            DB::transaction(function () use ($booking) {
                // supprime aussi les jours (cascade via FK déjà activée)
                $booking->delete();
            });
            return redirect()->route('admin.bookings.index')->with('success','Réservation supprimée.');
        } catch (\Throwable $e) {
            report($e);
            return back()->with('error','Suppression impossible pour le moment.');
        }
    }

    private function label(int $code): string {
        return ucfirst(str_replace('_',' ', $this->statusLabels[$code] ?? (string)$code));
    }
    private function plabel(int $code): string {
        return ucfirst(str_replace('_',' ', $this->paymentLabels[$code] ?? (string)$code));
    }
    private function appendNote(?string $existing, string $system, ?string $extra = null): string {
        $lines = array_filter(array_map('trim', explode("\n", (string)$existing)));
        $stamp = now()->format('Y-m-d H:i');
        $lines[] = "[{$stamp}] {$system}";
        if ($extra) $lines[] = "  ➤ {$extra}";
        return implode("\n", $lines);
    }








    private function resolveAssignablePlace(Booking $b) {
        $b->loadMissing([
            'bookable' => function (\Illuminate\Database\Eloquent\Relations\MorphTo $m) {
                $m->morphWith([Outing::class => ['outable']]);
            }
        ]);
        return $b->assignablePlace();
    }

    /** Guides éligibles (actifs + approuvés) pour le lieu */
    private function eligibleGuidesForPlace($place) {
        if (!$place) return collect();

        return Guide::query()
            ->join('guide_places as gp','gp.guide_id','=','guides.id')
            ->where('gp.placeable_type', get_class($place))
            ->where('gp.placeable_id', $place->id)
            ->where('gp.approved', 1)
            ->where('gp.is_active', 1)
            ->select(
                'guides.*',
                'gp.id as pivot_id',
                'gp.price as pivot_price',
                'gp.pricing_type'
            )
            ->orderBy('lastname')
            ->get();
    }



    private function loadPlaceModel(?array $sig) {
        if (!$sig) return null;
        $class = $sig['type'];
        if (!in_array($class, [Site::class], true)) {
            return null;
        }
        return $class::query()->find($sig['id']);
    }



    /** Signature du lieu: ['type'=>FQCN,'id'=>int] basé SEULEMENT sur Site/*/
    private function placeSignature(Booking $b): ?array {
        if (in_array($b->bookable_type, [Site::class], true)) {
            return ['type' => $b->bookable_type, 'id' => (int)$b->bookable_id];
        }
        return null; // autres types non concernés
    }

    /** Liste des guides attachés à CE lieu, actifs+approuvés, avec prix (depuis guide_places) */
    private function eligibleGuides(array $sig) {
        // Très important : utiliser le morphClass réellement stocké (alias si morphMap)
        $storedType = app($sig['type'])->getMorphClass();

        return Guide::query()
            ->join('guide_places as gp','gp.guide_id','=','guides.id')
            ->where('gp.placeable_type', $storedType)
            ->where('gp.placeable_id',   $sig['id'])
            ->where('gp.approved', 1)
            ->where('gp.is_active', 1)
            ->orderBy('lastname')
            ->get([
                'guides.*',
                'gp.id as pivot_id',
                'gp.price as pivot_price',
                'gp.pricing_type',
            ]);
    }

    /** Pivot du guide actuellement assigné (pour afficher son tarif) */
    private function assignedPivotFor(Booking $b, array $sig): ?GuidePlace {
        if (!$b->assigned_guide_id) return null;
        $storedType = app($sig['type'])->getMorphClass();
        return GuidePlace::query()
            ->where('guide_id', $b->assigned_guide_id)
            ->where('placeable_type', $storedType)
            ->where('placeable_id',   $sig['id'])
            ->first();
    }

    // --- actions --- //

    public function show(Booking $booking) {
        $booking->load(['client','days','bookable','guide']);

        $sig = $this->placeSignature($booking);
        $eligibleGuides = $sig ? $this->eligibleGuides($sig) : collect();
        $assignedPivot  = $sig ? $this->assignedPivotFor($booking, $sig) : null;

        return view('backend.admin.bookings.show', [
            'b'              => $booking,
            'statusLabels'   => $this->statusLabels,
            'paymentLabels'  => $this->paymentLabels,
            'eligibleGuides' => $eligibleGuides,
            'assignedPivot'  => $assignedPivot,
            'placeSig'       => $sig,
        ]);
    }

    public function assignGuide(Request $r, Booking $booking) {
        $sig = $this->placeSignature($booking);
        if (!$sig) return back()->with('warning','Cette réservation ne cible pas un lieu éligible.');

        $data = $r->validate([
            'guide_id' => ['required','integer','exists:guides,id'],
            'note'     => ['nullable','string','max:250'],
        ]);

        // Vérifier que le guide choisi est VRAIMENT attaché à ce lieu (actif+approuvé)
        $storedType = app($sig['type'])->getMorphClass();
        $ok = GuidePlace::query()
            ->where('guide_id', $data['guide_id'])
            ->where('placeable_type', $storedType)
            ->where('placeable_id',   $sig['id'])
            ->where('approved', 1)
            ->where('is_active', 1)
            ->exists();

        if (!$ok) {
            return back()->with('error', "Ce guide n'est pas éligible pour ce lieu.");
        }

        $booking->update([
            'assigned_guide_id' => (int)$data['guide_id'],
            // si tu veux garder une note interne :
            // 'note' => trim($booking->note."\n[".now()->format('Y-m-d H:i')."] Guide assigné: #{$data['guide_id']}".($data['note']? " ({$data['note']})":'')),
        ]);

        return back()->with('success','Guide assigné.');
    }

    public function unassignGuide(Booking $booking) {
        $booking->update(['assigned_guide_id' => null]);
        return back()->with('success','Guide retiré.');
    }

}








