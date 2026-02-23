<?php

namespace App\Http\Controllers;

use App\Models\OrderTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MonerooWebhookController extends Controller {
    public function handle(Request $request)
    {
        $payload = $request->getContent();
        $data    = $request->json()->all();

        // 1) Vérification signature (à adapter selon doc Moneroo)
        $webhookSecret = config('services.moneroo.webhook_secret');
        $signature     = $request->header('X-Moneroo-Signature');

        if ($webhookSecret && $signature) {
            $expected = hash_hmac('sha256', $payload, $webhookSecret);
            if (!hash_equals($expected, $signature)) {
                Log::warning('Moneroo webhook signature mismatch', [
                    'signature' => $signature,
                    'expected'  => $expected,
                ]);
                return response()->json(['error' => 'Invalid signature'], 403);
            }
        }

        $event       = $data['event'] ?? null;  // ex: payment.success
        $paymentData = $data['data']  ?? [];
        $transactionId = $paymentData['id'] ?? null;
        $status        = $paymentData['status'] ?? null;
        $metadata      = $paymentData['metadata'] ?? [];

        Log::info('Moneroo webhook received', [
            'event'         => $event,
            'status'        => $status,
            'transactionId' => $transactionId,
            'metadata'      => $metadata,
        ]);

        // 2) Retrouver la commande
        $orderTicketId = $metadata['order_ticket_id'] ?? null;

        $query = OrderTicket::query();

        if ($orderTicketId) {
            $query->where('id', $orderTicketId);
        } elseif ($transactionId) {
            $query->where('moneroo_transaction_id', $transactionId);
        }

        /** @var OrderTicket|null $orderTicket */
        $orderTicket = $query->first();

        if (!$orderTicket) {
            Log::warning('Moneroo webhook: OrderTicket not found', [
                'order_ticket_id'       => $orderTicketId,
                'moneroo_transaction_id'=> $transactionId,
            ]);

            // On répond 200 quand même pour éviter les retries infinis
            return response()->json(['ok' => true]);
        }

        // 3) Appliquer la logique en fonction de l’événement / statut
        if (in_array($event, ['payment.success']) || in_array($status, ['succeeded', 'paid'])) {
            if ($orderTicket->status !== 'paid') {
                $orderTicket->markAsPaidAndGenerateTickets();
            }
        } elseif (in_array($event, ['payment.failed', 'payment.cancelled']) || in_array($status, ['failed', 'cancelled'])) {
            if (!in_array($orderTicket->status, ['paid', 'completed'])) {
                $orderTicket->status = 'payment_failed';
                $orderTicket->save();
            }
        }

        return response()->json(['ok' => true]);
    }
}
