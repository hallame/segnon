<?php

namespace App\Http\Controllers\Partners;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Room;
use App\Models\Site;
use App\Models\Event;
use App\Models\Circuit;
use App\Support\CurrentAccount;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class PartnerBookingController extends Controller {
    /** Transitions AUTORISÉES pour un partenaire */
    private function allowedStatusTransitions(): array {
        $A = Booking::class;
        return [
            $A::STATUS_PENDING   => [$A::STATUS_CONFIRMED, $A::STATUS_CANCELLED],
            $A::STATUS_CONFIRMED => [$A::STATUS_CANCELLED, $A::STATUS_COMPLETED],
            $A::STATUS_CANCELLED => [],
            $A::STATUS_COMPLETED => [],
        ];
    }

    private function allowedPaymentTransitions(): array {
        $P = Booking::class;
        // Partenaire : pas de passage à VERIFIED/REJECTED (réservé admin)
        return [
            $P::PAY_UNPAID         => [$P::PAY_AWAITING_VERIF],
            $P::PAY_AWAITING_VERIF => [$P::PAY_UNPAID],
            $P::PAY_VERIFIED       => [],
            $P::PAY_REJECTED       => [],
        ];
    }

    /** Vérifie qu’une réservation appartient au compte courant */
    private function authorizeBooking(Booking $b): void {
        $accountId = (int) app(CurrentAccount::class)->id();
        $ok = false;

        if ((int)$b->account_id === $accountId) {
            $ok = true;
        } else {
            $b->loadMissing('bookable');
            $bk = $b->bookable;

            if ($bk instanceof Room) {
                $bk->loadMissing('hotel:id,account_id');
                $ok = (int) optional($bk->hotel)->account_id === $accountId;
            } elseif ($bk) {
                $ok = (int) data_get($bk, 'account_id') === $accountId;
            }
        }

        abort_unless($ok, 403, 'Accès refusé.');
    }

    /** Base scope: toutes les bookings du compte courant (account_id ou fallback via bookable) */
    private function baseScoped() {
        $accountId = (int) app(CurrentAccount::class)->id();

        return Booking::query()->where(function ($q) use ($accountId) {
            $q->where('account_id', $accountId)
              ->orWhere(function ($qq) use ($accountId) {
                  $qq->whereNull('account_id')
                     ->where(function ($w) use ($accountId) {
                         // Site / Circuit / Event avec account_id direct
                         $w->whereHasMorph('bookable', [Site::class, Circuit::class, Event::class],
                             fn($m) => $m->where('account_id', $accountId)
                         )
                         // Room -> via hotel.account_id
                         ->orWhereHasMorph('bookable', [Room::class],
                             fn($m) => $m->whereHas('hotel', fn($h) => $h->where('account_id', $accountId))
                         );
                     });
              });
        });
    }

    /** Requête paginée + filtres + eager loads pour l’index */
    private function scopedQuery(Request $r) {
        $q = $this->baseScoped()
            ->with(['bookable' => function (MorphTo $m) {
                $m->morphWith([
                    Site::class    => [],
                    Circuit::class => [],
                    Room::class    => ['hotel:id,account_id,name'],
                    Event::class   => [],
                ]);
            }]);

        // Filtres partenaires
        $qStr   = trim($r->input('q', ''));
        $status = $r->input('status');         // 0..3
        $pay    = $r->input('payment_status'); // 0..3
        $from   = $r->input('from');           // YYYY-MM-DD
        $to     = $r->input('to');             // YYYY-MM-DD

        $q->when($qStr, function ($qq) use ($qStr) {
            $qq->where(function ($sub) use ($qStr) {
                $sub->where('reference', 'like', "%$qStr%")
                    ->orWhere('payment_reference', 'like', "%$qStr%")
                    ->orWhere('confirmation_code', 'like', "%$qStr%");
            });
        })
        ->when($status !== null && $status !== '', fn($qq) => $qq->where('status', (int) $status))
        ->when($pay !== null && $pay !== '',     fn($qq) => $qq->where('payment_status', (int) $pay))
        ->when($from, fn($qq) => $qq->whereDate('check_in', '>=', $from))
        ->when($to,   fn($qq) => $qq->whereDate('check_out', '<=', $to));

        return $q->orderByDesc('created_at');
    }

    public function index(Request $r) {
        $bookings = $this->scopedQuery($r)->paginate(10)->withQueryString();

        // KPIs basés sur le même scope (sans filtres)
        $base = $this->baseScoped();
        $kpis = [
            'total'     => (clone $base)->count(),
            'pending'   => (clone $base)->where('status', Booking::STATUS_PENDING)->count(),
            'confirmed' => (clone $base)->where('status', Booking::STATUS_CONFIRMED)->count(),
            'completed' => (clone $base)->where('status', Booking::STATUS_COMPLETED)->count(),
            'cancelled' => (clone $base)->where('status', Booking::STATUS_CANCELLED)->count(),
            'revenue'   => (clone $base)->where('payment_status', Booking::PAY_VERIFIED)->sum('amount'),
        ];

        return view('backend.partners.bookings.index', [
            'bookings'      => $bookings,
            'kpis'          => $kpis,
            'currency'      => config('app.currency', 'GNF'),
            'statusLabels'  => Booking::STATUS_LABELS,
            'paymentLabels' => Booking::PAYMENT_LABELS,
            'filters'       => [
                'q'      => $r->input('q', ''),
                'status' => $r->input('status', ''),
                'pay'    => $r->input('payment_status', ''),
                'from'   => $r->input('from', ''),
                'to'     => $r->input('to', ''),
            ],
        ]);
    }

    public function show(Booking $booking) {
        $this->authorizeBooking($booking);
        $booking->load(['days', 'bookable']);
        return view('backend.partners.bookings.show', [
            'b'             => $booking,
            'statusLabels'  => Booking::STATUS_LABELS,
            'paymentLabels' => Booking::PAYMENT_LABELS,
        ]);
    }

    public function updateStatus(Request $r, Booking $booking) {
        $this->authorizeBooking($booking);

        $to = (int) $r->validate([
            'status' => ['required', Rule::in(array_keys(Booking::STATUS_LABELS))],
            'note'   => ['nullable', 'string', 'max:500'],
        ])['status'];

        $from    = (int) $booking->status;
        $allowed = $this->allowedStatusTransitions();

        if (!in_array($to, $allowed[$from] ?? [], true)) {
            return back()->with('warning', "Transition non autorisée.");
        }

        DB::transaction(function () use ($booking, $from, $to, $r) {
            if ($to === Booking::STATUS_CANCELLED && $from !== Booking::STATUS_CANCELLED) {
                $booking->days()->delete();
                $booking->cancellation_reason = $r->input('note');
            }
            $booking->status = $to;
            $booking->note   = $this->appendNote(
                $booking->note,
                "Status partenaire: " . Booking::statusLabel($from) . " → " . Booking::statusLabel($to),
                $r->input('note')
            );
            $booking->save();
        });

        return back()->with('success', 'Statut mis à jour.');
    }

    public function updatePayment(Request $r, Booking $booking) {
        $this->authorizeBooking($booking);

        $to = (int) $r->validate([
            'payment_status'    => ['required', Rule::in(array_keys(Booking::PAYMENT_LABELS))],
            'payment_reference' => ['nullable', 'string', 'max:120'],
            'note'              => ['nullable', 'string', 'max:500'],
        ])['payment_status'];

        $from    = (int) $booking->payment_status;
        $allowed = $this->allowedPaymentTransitions();

        if (!in_array($to, $allowed[$from] ?? [], true)) {
            return back()->with('warning', "Changement de paiement non autorisé pour un partenaire.");
        }

        $booking->update([
            'payment_status'    => $to,
            'payment_reference' => $r->input('payment_reference') ?: $booking->payment_reference,
            'note'              => $this->appendNote(
                $booking->note,
                "Paiement partenaire: " . Booking::paymentLabel($from) . " → " . Booking::paymentLabel($to),
                $r->input('note')
            ),
        ]);

        return back()->with('success', 'Paiement mis à jour.');
    }

    public function uploadReceipt(Request $r, Booking $booking) {
        $this->authorizeBooking($booking);

        $r->validate([
            'receipt' => ['required', 'file', 'mimes:jpg,jpeg,png,webp,pdf', 'max:5120'],
        ]);

        if ($booking->payment_receipt_path) {
            Storage::disk('public')->delete($booking->payment_receipt_path);
        }

        $path = $r->file('receipt')->store('receipts', 'public');
        $booking->update(['payment_receipt_path' => $path]);

        return back()->with('success', 'Reçu envoyé.');
    }

    public function deleteReceipt(Booking $booking) {
        $this->authorizeBooking($booking);

        if ($booking->payment_receipt_path) {
            Storage::disk('public')->delete($booking->payment_receipt_path);
            $booking->update(['payment_receipt_path' => null]);
        }
        return back()->with('success', 'Reçu supprimé.');
    }

    private function appendNote(?string $existing, string $system, ?string $extra = null): string {
        $lines = array_filter(array_map('trim', explode("\n", (string) $existing)));
        $lines[] = '[' . now()->format('Y-m-d H:i') . '] ' . $system;
        if ($extra) $lines[] = '  ➤ ' . $extra;
        return implode("\n", $lines);
    }
}
