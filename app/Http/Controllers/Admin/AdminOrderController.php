<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;


class AdminOrderController extends Controller {
     public function index(Request $request) {
        $q      = trim($request->input('q',''));
        $status = $request->input('status');       // entier (0..5) ou vide
        $from   = $request->input('from');         // YYYY-MM-DD
        $to     = $request->input('to');           // YYYY-MM-DD

        $orders = Order::query()
            ->when($q, function($qq) use ($q){
                $qq->where(function($sub) use ($q){
                    $sub->where('reference','like',"%$q%")
                        ->orWhere('customer_firstname','like',"%$q%")
                        ->orWhere('customer_lastname','like',"%$q%")
                        ->orWhere('customer_email','like',"%$q%")
                        ->orWhere('customer_phone','like',"%$q%");
                });
            })
            ->when($status !== null && $status !== '', fn($qq)=>$qq->where('status', (int)$status))
            ->when($from, fn($qq)=>$qq->whereDate('created_at','>=',$from))
            ->when($to,   fn($qq)=>$qq->whereDate('created_at','<=',$to))
            ->orderByDesc('created_at')
            ->paginate(20)
            ->withQueryString();

        // KPIs
        $stats = [
            'total'       => Order::count(),
            'today'       => Order::whereDate('created_at', now()->toDateString())->count(),
            'pending'     => Order::where('status', Order::STATUS_PENDING)->count(),
            'under_review'=> Order::where('status', Order::STATUS_UNDER_REVIEW)->count(),
            'paid'        => Order::where('status', Order::STATUS_PAID)->count(),
            'rejected'    => Order::where('status', Order::STATUS_REJECTED)->count(),
            'cancelled'   => Order::where('status', Order::STATUS_CANCELLED)->count(),
            'fulfilled'   => Order::where('status', Order::STATUS_FULFILLED)->count(),
        ];

        return view('backend.admin.orders.index', compact('orders','stats','q','status','from','to'));
    }

    public function show(Order $order) {
        $order->load(['items.product']); // produit + lignes
        return view('backend.admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order) {
        $validStatuses = array_keys(Order::$statusLabels); // [0,1,2,3,4,5]

        $data = $request->validate([
            'status' => ['required', Rule::in($validStatuses)],
            'note'   => ['nullable','string','max:500'],
        ]);
        $to   = (int)$data['status'];
        $from = (int)$order->status;

        // Règles de transition (simples et sûres)
        $A = Order::class;
        $allowed = [
            $A::STATUS_PENDING       => [$A::STATUS_UNDER_REVIEW, $A::STATUS_PAID, $A::STATUS_CANCELLED, $A::STATUS_REJECTED],
            $A::STATUS_UNDER_REVIEW  => [$A::STATUS_PAID, $A::STATUS_CANCELLED, $A::STATUS_REJECTED],
            $A::STATUS_PAID          => [$A::STATUS_FULFILLED, $A::STATUS_CANCELLED],
            $A::STATUS_REJECTED      => [],    // terminal
            $A::STATUS_CANCELLED     => [],    // terminal
            $A::STATUS_FULFILLED     => [],    // terminal
        ];
        if (!in_array($to, $allowed[$from] ?? [], true)) {
            return back()->with('warning', "Transition non autorisée : '{$order->status_label}' → '".(Order::$statusLabels[$to] ?? $to)."'");
        }

        DB::transaction(function () use ($order, $from, $to, $data) {
            // Restock si on passe à "cancelled" depuis un autre statut
            if ($to === Order::STATUS_CANCELLED && $from !== Order::STATUS_CANCELLED) {
                $order->loadMissing('items.product');
                foreach ($order->items as $it) {
                    if ($it->product) {
                        $it->product->increment('stock', (int)$it->qty);
                    }
                }
            }
            $order->update([
                'status' => $to,
                'note'   => $this->appendNote($order->note, "Statut: {$order->status_label} → ".(Order::$statusLabels[$to] ?? $to), $data['note'] ?? null),
            ]);
        });

        return back()->with('success','Statut mis à jour.');
    }

    public function destroy(Order $order) {
        // Évite de supprimer une commande terminée
        if (in_array((int)$order->status, [Order::STATUS_FULFILLED, Order::STATUS_PAID], true)) {
            return back()->with('warning','Commande engagée/finalisée : suppression déconseillée.');
        }
        try {
            DB::transaction(function () use ($order) {
                $order->items()->delete();
                $order->delete();
            });
            return redirect()->route('admin.orders.index')->with('success','Commande supprimée.');
        } catch (\Throwable $e) {
            report($e);
            return back()->with('error','Suppression impossible pour le moment.');
        }
    }
    private function appendNote(?string $existing, string $system, ?string $extra = null): string {
        $lines = array_filter(array_map('trim', explode("\n", (string)$existing)));
        $stamp = now()->format('Y-m-d H:i');
        $lines[] = "[{$stamp}] {$system}";
        if ($extra) $lines[] = "  ➤ {$extra}";
        return implode("\n", $lines);
    }
}
