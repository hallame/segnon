<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\OrderTicket;
use App\Models\Payment;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AdminTicketOrderController extends Controller {


    public function index(Request $request) {
        // --- Filtres de base ---
        $query = OrderTicket::with('event')->latest();

        if ($request->filled('event_id')) {
            $query->where('event_id', $request->event_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('q')) {
            $q = trim($request->q);
            $query->where(function ($sub) use ($q) {
                $sub->where('reference', 'like', "%{$q}%")
                    ->orWhere('customer_email', 'like', "%{$q}%")
                    ->orWhere('customer_firstname', 'like', "%{$q}%")
                    ->orWhere('customer_lastname', 'like', "%{$q}%");
            });
        }

        $orders = $query->paginate(25)->withQueryString();

        // --- Stats globales ---
        $stats = [
            'total'            => OrderTicket::count(),
            'draft'            => OrderTicket::where('status', 'draft')->count(),
            'awaiting_payment' => OrderTicket::where('status', 'awaiting_payment')->count(),
            'paid'             => OrderTicket::where('status', 'paid')->count(),
            'cancelled'        => OrderTicket::where('status', 'cancelled')->count(),
        ];

        // Pour le select d’événements
        $events = Event::orderBy('name')->get();

        // Options de statut (labels humains)
        $statusOptions = [
            'draft'            => 'Brouillon',
            'awaiting_payment' => 'En attente paiement',
            'paid'             => 'Payée',
            'payment_failed'    => 'Échec',
            'cancelled'        => 'Annulée',
        ];


        $filters = [
            'event_id' => $request->event_id,
            'status'   => $request->status,
            'q'        => $request->q,
        ];

        return view('backend.admin.tickets.orders.index', compact(
            'orders',
            'stats',
            'events',
            'filters',
            'statusOptions'
        ));
    }


    public function show(OrderTicket $orderTicket) {
        $orderTicket->load([
            'event',
            'items',
            'payments' => fn($q) => $q->latest(),
            'tickets'  => fn($q) => $q->with('ticketType'),
        ]);

        return view('backend.admin.tickets.orders.show', [
            'order' => $orderTicket,
        ]);
    }

    public function verifyPayment(Request $request, Payment $payment, PaymentService $paymentService) {

        $note = $request->input('note');

        $paymentService->verifyTicketPayment($payment, Auth::id(), $note);

        return back()->with('success', 'Paiement validé et tickets associés.');
    }


    public function rejectPayment(Request $request, Payment $payment, PaymentService $paymentService) {

        $note = $request->input('note');
        $paymentService->rejectTicketPayment($payment, Auth::id(), $note);

        return back()->with('success', 'Paiement rejeté et client notifié.');
    }
}
