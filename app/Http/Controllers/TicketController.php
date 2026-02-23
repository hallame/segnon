<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Ticket;
use App\Models\TicketType;
use App\Models\OrderTicket;
use App\Models\OrderTicketItem;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Services\MonerooPaymentService;


class TicketController extends Controller {

    public function buy(Event $event) {
        $event->load(['category', 'country', 'language']);

        $types = TicketType::where('event_id', $event->id)
            ->where('is_active', true)
            ->orderBy('price')
            ->get();

        $now   = now();
        $endAt = $event->end_date
            ?? $event->end_at
            ?? $event->ends_at
            ?? null;

        if ($endAt instanceof \Carbon\Carbon) {
            $eventEnded = $now->gt($endAt);
        } elseif ($endAt) {
            $eventEnded = $now->gt(\Carbon\Carbon::parse($endAt));
        } else {
            $eventEnded = false;
        }

        return view('frontend.events.tickets.buy', compact('event', 'types', 'eventEnded'));
    }

    public function reserve(Request $request, Event $event) {
        $now = now();

        // Sécurité : event terminé ?
        $endAt = $event->end_date
            ?? $event->end_at
            ?? $event->ends_at
            ?? null;


        if ($endAt && $now->gt($endAt)) {
            return back()
                ->withErrors(['lines' => "Cet événement est terminé, vous ne pouvez plus acheter de billets."])
                ->withInput();
        }

        // Tous les types actifs pour cet event (indexés par id)
        $types = TicketType::where('event_id', $event->id)
            ->where('is_active', true)
            ->get()
            ->keyBy('id');


        // 1) Validation structurelle
        $validator = Validator::make($request->all(), [
            'lines'                  => ['required', 'array'],
            'lines.*.ticket_type_id' => ['nullable', 'integer'],
            'lines.*.qty'            => ['nullable', 'integer', 'min:0'],
        ], [
            'lines.required' => 'Veuillez choisir au moins un type de billet.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data     = $validator->validated();
        $lines    = $data['lines'] ?? [];
        $selected = [];

        // 2) Normalisation + règles métier
        foreach ($lines as $row) {
            $typeId = $row['ticket_type_id'] ?? null;
            $qty    = (int)($row['qty'] ?? 0);

            // on ignore les lignes vides
            if (!$typeId || $qty <= 0) {
                continue;
            }

            if (!isset($types[$typeId])) {
                return back()
                    ->withErrors(['lines' => 'Un type de billet sélectionné n’est pas valide pour cet événement.'])
                    ->withInput();
            }

            /** @var \App\Models\TicketType $type */
            $type = $types[$typeId];

            // Fenêtre de vente
            $canBuyWindow = true;
            if ($type->sales_start && $now->lt($type->sales_start)) $canBuyWindow = false;
            if ($type->sales_end   && $now->gt($type->sales_end))   $canBuyWindow = false;

            if (!$canBuyWindow) {
                return back()
                    ->withErrors(['lines' => "Les ventes sont fermées pour le billet « {$type->name} »."])
                    ->withInput();
            }

            // Capacité / reste
            $rawRemaining = $type->remaining_tickets_count ?? null;
            if (is_null($rawRemaining)) {
                if (!is_null($type->quantity)) {
                    $rawRemaining = (int) $type->quantity;
                } else {
                    $rawRemaining = 9999; // disponibilité élevée
                }
            }

            $remaining   = max(0, (int) $rawRemaining);
            $maxPerOrder = $type->max_per_order ?: 6;
            $maxAllowed  = min($remaining, $maxPerOrder);

            if ($remaining <= 0) {
                return back()
                    ->withErrors(['lines' => "Le ticket « {$type->name} » est fini."])
                    ->withInput();
            }

            if ($qty > $maxAllowed) {
                return back()
                    ->withErrors(['lines' => "La quantité demandée pour « {$type->name} » dépasse le maximum autorisé ({$maxAllowed})."])
                    ->withInput();
            }

            $selected[] = [
                'type' => $type,
                'qty'  => $qty,
            ];
        }


        // 3) au moins un type choisi
        if (empty($selected)) {
            return back()
                ->withErrors(['lines' => 'Choisissez au moins un ticket.'])
                ->withInput();
        }

        // 4) Création de la commande + lignes
        $orderTicket = DB::transaction(function () use ($event, $selected) {
            $currency = 'GNF'; // à adapter si tu as une colonne sur event

            $subtotal = 0;
            foreach ($selected as $line) {
                $subtotal += $line['type']->price * $line['qty'];
            }

            /** @var \App\Models\OrderTicket $order */
            $order = OrderTicket::create([
                'reference'          => 'TCK-'.now()->format('Ymd-His').'-'.Str::upper(Str::random(5)),
                'event_id'           => $event->id,
                'account_id'         => $event->account_id ?? null,
                'user_id'            => optional(Auth::user())->id,
                'customer_firstname' => Auth::user()->firstname ?? '',
                'customer_lastname'  => Auth::user()->lastname ?? '',
                'customer_email'     => Auth::user()->email ?? '',
                'customer_phone'     => Auth::user()->phone ?? null,
                'subtotal'           => $subtotal,
                'discount'           => 0,
                'tax'                => 0,
                'total'              => $subtotal,
                'currency'           => $currency,
                'status'             => 'draft', // ou OrderTicket::ST_DRAFT
            ]);

            foreach ($selected as $line) {
                $type = $line['type'];

                OrderTicketItem::create([
                    'order_ticket_id'   => $order->id,
                    'ticket_type_id'    => $type->id,
                    'ticket_id'         => null, // remplira après génération des tickets
                    'ticket_type_name'  => $type->name,
                    'unit_price'        => $type->price,
                    'qty'               => $line['qty'],
                    'total_price'       => $type->price * $line['qty'],
                ]);
            }

            return $order;
        });

        // 5) Redirection vers le checkout (récap + paiement)
        return redirect()->route('events.checkout', [$event, $orderTicket]);
    }


    public function checkout(Event $event, OrderTicket $orderTicket) {
        abort_unless($orderTicket->event_id === $event->id, 404);

        // si déjà payé / terminé → on renvoie sur confirmation
        if (!in_array($orderTicket->status, ['draft', 'awaiting_payment', 'payment_failed'])) {
            return redirect()->route('events.confirmation', [$event, $orderTicket]);
        }

        $orderTicket->load('items');

        $methods = PaymentMethod::with(['mobileMoney','bank','cash','card','cod'])
            ->where('active', true)
            ->orderBy('position')
            ->get();

        return view('frontend.events.tickets.checkout', [
            'event'   => $event,
            'ot'      => $orderTicket,
            'methods' => $methods,
        ]);
    }

    public function pay(Request $request, Event $event, OrderTicket $orderTicket, PaymentService $paymentService) {
        abort_unless($orderTicket->event_id === $event->id, 404);

        $validated = $request->validate([
            'customer_firstname' => ['required','string','max:255'],
            'customer_lastname'  => ['required','string','max:255'],
            'customer_email'     => ['required','email','max:255'],
            'customer_phone'     => ['required','string','max:50'],
            'payment_method_id'  => ['required','exists:payment_methods,id'],
            'transaction_number' => ['nullable','string','max:255'],
            'note'               => ['nullable','string','max:2000'],
            'receipt'            => ['nullable','file','mimes:jpg,jpeg,png,pdf','max:4096'],
        ]);

        // snapshot client
        $orderTicket->update([
            'customer_firstname' => $validated['customer_firstname'],
            'customer_lastname'  => $validated['customer_lastname'],
            'customer_email'     => $validated['customer_email'],
            'customer_phone'     => $validated['customer_phone'] ?? null,
        ]);

        $data = [
            'payment_method_id'  => $validated['payment_method_id'],
            'transaction_number' => $validated['transaction_number'] ?? null,
            'note'               => $validated['note'] ?? null,
            'user_id'            => optional($request->user())->id,
        ];

        // méthode à ajouter dans PaymentService (voir plus bas)
        $payment = $paymentService->submitForTicket(
            $orderTicket,
            $data,
            $request->file('receipt')
        );

        return redirect()
            ->route('events.confirmation', [$event, $orderTicket])
            ->with('success', 'Votre paiement a été soumis, il sera vérifié par un administrateur.');
    }


    public function payOnline( Request $request,  Event $event,  OrderTicket $orderTicket,  MonerooPaymentService $moneroo ) {
        abort_unless($orderTicket->event_id === $event->id, 404);
        if ($orderTicket->total <= 0) {
            abort(403, 'Ce paiement ne peut pas être traité (montant nul).');
        }


        // Même snapshot client que pay(), mais sans payment_method_id etc.
        $validated = $request->validate([
            'customer_firstname' => ['required','string','max:255'],
            'customer_lastname'  => ['required','string','max:255'],
            'customer_email'     => ['required','email','max:255'],
            'customer_phone'     => ['required','string','max:50'],
        ]);

        $orderTicket->update([
            'customer_firstname' => $validated['customer_firstname'],
            'customer_lastname'  => $validated['customer_lastname'],
            'customer_email'     => $validated['customer_email'],
            'customer_phone'     => $validated['customer_phone'],
        ]);

        $payment = $moneroo->initForTicket($orderTicket);

        return redirect()->away($payment->checkout_url);
    }


    public function handleMonerooReturn(Request $request, OrderTicket $orderTicket,  MonerooPaymentService $moneroo) {
        $transactionId = $request->query('transaction_id')
            ?? $request->query('id')
            ?? $orderTicket->moneroo_transaction_id;

        if (!$transactionId) {
            return redirect()
                ->route('events.confirmation', [$orderTicket->event, $orderTicket])
                ->with('error', 'Référence de paiement introuvable.');
        }

        try {
            $payment = $moneroo->verify($transactionId);
        } catch (\Throwable $e) {
            // log technique
            logger()->error('Moneroo verify error', [
                'transaction_id' => $transactionId,
                'order_ticket_id' => $orderTicket->id,
                'error' => $e->getMessage(),
            ]);

            return redirect()
                ->route('events.checkout', [$orderTicket->event, $orderTicket])
                ->with('error', 'Impossible de vérifier le paiement pour le moment. Merci de réessayer.');
        }

        $status = $payment->status ?? null;


        $statusRaw = $payment->status ?? null;
        $status    = $statusRaw ? strtolower(trim($statusRaw)) : null;

        // log
        logger()->info('Moneroo payment status', [
            'transaction_id'   => $transactionId,
            'order_ticket_id'  => $orderTicket->id,
            'status_raw'       => $statusRaw,
            'status_normalized'=> $status,
        ]);

        // 1) Paiement OK
        if (in_array($status, ['succeeded', 'paid', 'success', 'completed'])) {

            $method = PaymentMethod::where('type', 'online')->where('key', 'moneroo')->first();
            // Créer un Payment "auto-vérifié"
            $orderTicket->payments()->create([
                'reference'          => 'MON-'.now()->format('Ymd-His').'-'.str()->upper(str()->random(6)),
                'payment_method_id'  => $method?->id,
                'user_id'            => $orderTicket->user_id,
                'amount'             => $orderTicket->total,
                'currency'           => $orderTicket->currency,
                'transaction_number' => $transactionId,
                'status'             => Payment::STATUS_VERIFIED,
                'submitted_at'       => now(),
                'verified_at'        => now(),
                'verified_by'        => null,
                'note'               => 'Paiement confirmé via Moneroo',
            ]);


            $orderTicket->markAsPaidAndAssignTickets();

            return redirect()
                ->route('events.confirmation', [$orderTicket->event, $orderTicket])
                ->with('success', 'Paiement confirmé avec succès.');
        }

        // 2) Toujours en attente côté PSP
        if (in_array($status, ['pending', 'processing', 'waiting'])) {
            $orderTicket->status = 'awaiting_payment';
            $orderTicket->save();

            return redirect()
                ->route('events.confirmation', [$orderTicket->event, $orderTicket])
                ->with('info', 'Votre paiement est en cours de traitement. Vous recevrez une confirmation dès validation.');
        }

        // 3) Échec / annulé
        $orderTicket->status = 'payment_failed';
        $orderTicket->save();

        return redirect()
            ->route('events.checkout', [$orderTicket->event, $orderTicket])
            ->with('error', 'Paiement non confirmé. Vous pouvez réessayer ou choisir un autre moyen de paiement.');

    }


    public function confirmation(Event $event, OrderTicket $orderTicket) {
        abort_unless($orderTicket->event_id === $event->id, 404);

        $orderTicket->load([
            'items',
            'payments' => function($q) { $q->latest(); },
        ]);

        return view('frontend.events.tickets.confirmation', [
            'event' => $event,
            'ot'    => $orderTicket,
        ]);
    }
}
