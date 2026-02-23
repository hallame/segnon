<?php

namespace App\Http\Controllers\Partners;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductSku;
use App\Support\CurrentAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PartnerOrderController extends Controller {
    /** Transitions autorisées pour un partenaire sur une commande MONO-vendeur */
    private function allowed(): array {
        $A = Order::class;
        return [
            $A::STATUS_PENDING       => [$A::STATUS_UNDER_REVIEW, $A::STATUS_CANCELLED],
            $A::STATUS_UNDER_REVIEW  => [$A::STATUS_CANCELLED],
            $A::STATUS_PAID          => [$A::STATUS_FULFILLED, $A::STATUS_CANCELLED],
            $A::STATUS_REJECTED      => [],
            $A::STATUS_CANCELLED     => [],
            $A::STATUS_FULFILLED     => [],
        ];
    }

    private function accountId(): int {
        return (int) app(CurrentAccount::class)->id();
    }

    /** Clause réutilisable: items appartenant au compte courant (order_items.account_id || fallback product.account_id) */
    private function itemsBelongingToAccount($q, int $accountId): void {
        $q->where(function ($w) use ($accountId) {
            $w->where('order_items.account_id', $accountId)
              ->orWhere(function ($x) use ($accountId) {
                  $x->whereNull('order_items.account_id')
                    ->whereHas('product', fn($p) => $p->where('account_id', $accountId));
              });
        });
    }

    /** Query scoppée au partenaire, bien groupée */
    private function scopedQuery(Request $r) {
        $aid    = $this->accountId();
        $q      = trim((string) $r->input('q',''));
        $status = $r->input('status');
        $from   = $r->input('from');
        $to     = $r->input('to');

        return Order::query()
            ->with([
                // Ne charger QUE les items du partenaire
                'items' => function ($i) use ($aid) { $this->itemsBelongingToAccount($i, $aid); },
                'items.product','items.sku'
            ])
            // IMPORTANT: tout le scope vendeur dans un SEUL where(...)
            ->where(function ($scoped) use ($aid) {
                $scoped->where('account_id', $aid) // commandes mono-vendeur (ton optimisation)
                       ->orWhereHas('items', function ($i) use ($aid) {
                           $this->itemsBelongingToAccount($i, $aid);
                       });
            })
            // Filtres utilisateur
            ->when($q, function ($qq) use ($q) {
                $qq->where(function($sub) use ($q){
                    $sub->where('reference','like',"%{$q}%")
                        ->orWhere('customer_firstname','like',"%{$q}%")
                        ->orWhere('customer_lastname','like',"%{$q}%")
                        ->orWhere('customer_email','like',"%{$q}%")
                        ->orWhere('customer_phone','like',"%{$q}%");
                });
            })
            ->when($status !== null && $status !== '', fn($qq)=>$qq->where('status', (int)$status))
            ->when($from, fn($qq)=>$qq->whereDate('created_at','>=',$from))
            ->when($to,   fn($qq)=>$qq->whereDate('created_at','<=',$to))
            // Somme des totaux juste pour CE partenaire
            ->withSum(['items as vendor_total' => function ($i) use ($aid) {
                $this->itemsBelongingToAccount($i, $aid);
            }], 'total_price')
            ->orderByDesc('created_at');
    }

    /** True si la commande contient des articles de plusieurs vendeurs */
    private function isMultiVendor(Order $order): bool {
        // on lit les items déjà filtrés ? Ici on veut le set complet :
        $vendors = $order->items()
            ->select(['order_items.account_id'])
            ->with('product:id,account_id')
            ->get()
            ->map(function($it){
                return $it->account_id ?? $it->product?->account_id;
            })
            ->filter()
            ->unique()
            ->values();

        return $vendors->count() > 1;
    }

    /** Vérifie que la commande contient AU MOINS un article du partenaire */
    private function authorizeOrder(Order $o): void {
        $aid = $this->accountId();

        $ok = (int) $o->account_id === $aid
            || $o->items()->where(function($i) use ($aid) {
                $this->itemsBelongingToAccount($i, $aid);
            })->exists();

        abort_unless($ok, 403);
    }

    public function index(Request $r) {
        $orders = $this->scopedQuery($r)->paginate(10)->withQueryString();

        // KPIs scoppés (compte courant)
        $aid = $this->accountId();
        $kbase = Order::query()
            ->where(function ($scoped) use ($aid) {
                $scoped->where('account_id', $aid)
                       ->orWhereHas('items', function ($i) use ($aid) {
                           $this->itemsBelongingToAccount($i, $aid);
                       });
            });

        $stats = [
            'total'        => (clone $kbase)->count(),
            'today'        => (clone $kbase)->whereDate('created_at', now()->toDateString())->count(),
            'pending'      => (clone $kbase)->where('status', Order::STATUS_PENDING)->count(),
            'under_review' => (clone $kbase)->where('status', Order::STATUS_UNDER_REVIEW)->count(),
            'paid'         => (clone $kbase)->where('status', Order::STATUS_PAID)->count(),
            'rejected'     => (clone $kbase)->where('status', Order::STATUS_REJECTED)->count(),
            'cancelled'    => (clone $kbase)->where('status', Order::STATUS_CANCELLED)->count(),
            'fulfilled'    => (clone $kbase)->where('status', Order::STATUS_FULFILLED)->count(),
        ];

        return view('backend.shop.orders.index', [
            'orders'   => $orders,
            'stats'    => $stats,
            'currency' => config('app.currency'),
            'q'        => $r->input('q',''),
            'status'   => $r->input('status',''),
            'from'     => $r->input('from',''),
            'to'       => $r->input('to',''),
        ]);
    }

    public function show(Order $order) {
        $this->authorizeOrder($order);
        $aid = $this->accountId();

        // Charger UNIQUEMENT les items du partenaire
        $order->load([
            'items' => function ($i) use ($aid) { $this->itemsBelongingToAccount($i, $aid); },
            'items.product','items.sku'
        ]);

        // Total partenaire
        $vendorTotal = $order->items()->where(function($i) use ($aid){
            $this->itemsBelongingToAccount($i, $aid);
        })->sum('total_price');

        return view('backend.shop.orders.show', [
            'order'        => $order,
            'statusLabels' => Order::$statusLabels,
            'allowedNext'  => $this->allowed()[$order->status] ?? [],
            'vendorTotal'  => $vendorTotal,
            'isMulti'      => $this->isMultiVendor($order),
        ]);
    }

    public function updateStatus(Request $request, Order $order) {
        $this->authorizeOrder($order);

        // Interdire changement de statut si commande multi-vendeur
        if ($this->isMultiVendor($order)) {
            return back()->with('warning', "Commande multi-vendeur : modification du statut réservée à l’administrateur.");
        }

        $valid = array_keys(Order::$statusLabels);
        $data = $request->validate([
            'status' => ['required', Rule::in($valid)],
            'note'   => ['nullable','string','max:500'],
        ]);

        $to   = (int) $data['status'];
        $from = (int) $order->status;

        $allowed = $this->allowed();
        if (!in_array($to, $allowed[$from] ?? [], true)) {
            return back()->with('warning', "Transition non autorisée.");
        }

        DB::transaction(function () use ($order, $from, $to, $data) {
            if ($to === Order::STATUS_CANCELLED && $from !== Order::STATUS_CANCELLED) {
                $order->loadMissing('items.product','items.sku');
                foreach ($order->items as $it) {
                    if ($it->sku)      $it->sku->increment('stock', (int) $it->qty);
                    elseif ($it->product) $it->product->increment('stock', (int) $it->qty);
                }
            }
            $old = $order->status_label;
            $order->update([
                'status' => $to,
                'note'   => $this->appendNote($order->note, "Statut partenaire: {$old} → ".(Order::$statusLabels[$to] ?? $to), $data['note'] ?? null),
            ]);
        });

        return back()->with('success', 'Statut mis à jour.');
    }

    private function appendNote(?string $existing, string $system, ?string $extra = null): string {
        $lines = array_filter(array_map('trim', explode("\n", (string)$existing)));
        $stamp = now()->format('Y-m-d H:i');
        $lines[] = "[{$stamp}] {$system}";
        if ($extra) $lines[] = "  ➤ {$extra}";
        return implode("\n", $lines);
    }
}
