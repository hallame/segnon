<?php

namespace App\Services;

use App\Models\{Order, OrderTicket, Payment, PaymentMethod, Setting, Ticket};
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use App\Mail\PaymentSubmittedMail;
use App\Mail\PaymentVerifiedMail;
use App\Mail\TicketAdminNewOrderMail;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use App\Mail\TicketPaymentVerifiedMail;
use App\Mail\TicketPaymentRejectedMail;
use App\Mail\TicketPaymentSubmittedMail;

class PaymentService {

    // orders
    public function submit(Order $order, array $data, ?UploadedFile $receipt = null): Payment {
        return DB::transaction(function () use ($order, $data, $receipt) {
            // lock pour éviter races
            $order->payments()->lockForUpdate()->get();

            $exists = $order->payments()
                ->where('payment_method_id', $data['payment_method_id'])
                ->where('amount', $order->total)
                ->where('status', Payment::STATUS_SUBMITTED)
                ->where('created_at', '>=', now()->subMinutes(5))
                ->exists();

            if ($exists) {
                $existing = $order->payments()
                    ->where('status', Payment::STATUS_SUBMITTED)
                    ->latest('id')->first();

                $toUpdate = [];
                if (!empty($data['transaction_number']) && empty($existing->transaction_number)) {
                    $toUpdate['transaction_number'] = $data['transaction_number'];
                }
                if (!empty($data['note'])) {
                    $toUpdate['note'] = trim(($existing->note ? $existing->note."\n" : '').$data['note']);
                }
                if ($toUpdate) $existing->update($toUpdate);
                if ($receipt instanceof UploadedFile) {
                    $existing->addMedia($receipt)->toMediaCollection('receipt');
                }
                return $existing;
            }

            $payment = $order->payments()->create([
                'reference'         => 'PAY-'.now()->format('Ymd-His').'-'.str()->upper(str()->random(6)),
                'payment_method_id' => $data['payment_method_id'],
                'user_id'         => $data['user_id'] ?? null,
                'amount'            => $order->total,
                'currency'          => Setting::where('key', 'currency')->value('value'),
                'transaction_number'=> $data['transaction_number'] ?? null,
                'status'            => Payment::STATUS_SUBMITTED,
                'submitted_at'      => now(),
                'note'              => $data['note'] ?? null,
            ]);

            if ($receipt instanceof UploadedFile) {
                $payment->addMedia($receipt)->toMediaCollection('receipt');
            }

            // passer la commande en "under_review"
            if ((int)$order->status === Order::STATUS_PENDING) {
                $order->update(['status' => Order::STATUS_UNDER_REVIEW]);
            }

            return $payment;
        });
    }

    public function verify(Payment $payment, int $adminId, ?string $note = null): void {
        DB::transaction(function () use ($payment, $adminId, $note) {
            if ($payment->status !== Payment::STATUS_SUBMITTED) return;


            $payment->update([
                'status'      => Payment::STATUS_VERIFIED,
                'verified_at' => now(),
                'verified_by' => $adminId,
                'note'        => $note ?? $payment->note,
            ]);


            // if ($payment->payable instanceof Order) {
            //    $payment->payable->update(['status' => \App\Models\Order::STATUS_PAID]);
            // }


            $pdf = Pdf::setOptions(['isRemoteEnabled'=>true,'dpi'=>110,'defaultFont'=>'DejaVu Sans'])
                    ->loadView('frontend.shop.receipt', ['order'=>$payment->payable,'qrPng'=>base64_encode(''), 'isPaid'=>true])
                    ->setPaper('a4');
            $pdfData = $pdf->output();
            // Mail::to($payment->payable->customer_email)
            // ->send(new PaymentVerifiedMail($payment->payable, $payment, $pdfData));

            // Option: check type
            if ($payment->payable && $payment->payable instanceof Order) {
                $payment->payable->update(['status' => 2]);
            }
        });

    }

    public function reject(Payment $payment, int $adminId, ?string $note = null): void {
        DB::transaction(function () use ($payment, $adminId, $note) {
            if ($payment->status !== Payment::STATUS_SUBMITTED) return;
            $payment->update([
                'status'      => Payment::STATUS_REJECTED,
                'verified_at' => now(),
                'verified_by' => $adminId,
                'note'        => $note ?? $payment->note,
            ]);

            // Mail::to($payment->payable->customer_email)->send(new PaymentSubmittedMail($payment->payable, $payment));

            // Option: check type
            if ($payment->payable && $payment->payable instanceof Order) {
                $payment->payable->update(['status' => 3]);
            }
        });
    }


    // tickets
    public function submitForTicket(OrderTicket $orderTicket, array $data, ?UploadedFile $receipt = null): Payment {
        return DB::transaction(function () use ($orderTicket, $data, $receipt) {
            // lock pour éviter les courses
            $orderTicket->payments()->lockForUpdate()->get();

            $exists = $orderTicket->payments()
                ->where('payment_method_id', $data['payment_method_id'])
                ->where('amount', $orderTicket->total)
                ->where('status', Payment::STATUS_SUBMITTED)
                ->where('created_at', '>=', now()->subMinutes(5))
                ->exists();

            if ($exists) {
                $existing = $orderTicket->payments()
                    ->where('status', Payment::STATUS_SUBMITTED)
                    ->latest('id')->first();

                $toUpdate = [];
                if (!empty($data['transaction_number']) && empty($existing->transaction_number)) {
                    $toUpdate['transaction_number'] = $data['transaction_number'];
                }
                if (!empty($data['note'])) {
                    $toUpdate['note'] = trim(($existing->note ? $existing->note . "\n" : '') . $data['note']);
                }
                if ($toUpdate) {
                    $existing->update($toUpdate);
                }
                if ($receipt instanceof UploadedFile) {
                    $existing->addMedia($receipt)->toMediaCollection('receipt');
                }

                return $existing;
            }

            $payment = $orderTicket->payments()->create([
                'reference'          => 'PAY-' . now()->format('Ymd-His') . '-' . str()->upper(str()->random(6)),
                'payment_method_id'  => $data['payment_method_id'],
                'user_id'            => $data['user_id'] ?? null,
                'amount'             => $orderTicket->total,
                'currency'           => Setting::where('key', 'currency')->value('value'),
                'transaction_number' => $data['transaction_number'] ?? null,
                'status'             => Payment::STATUS_SUBMITTED,
                'submitted_at'       => now(),
                'note'               => $data['note'] ?? null,
            ]);

            if ($receipt instanceof UploadedFile) {
                $payment->addMedia($receipt)->toMediaCollection('receipt');
            }

            // commande en "awaiting_payment"
            if ($orderTicket->status === OrderTicket::ST_DRAFT ?? 'draft') {
                $orderTicket->update(['status' => OrderTicket::ST_AWAITING ?? 'awaiting_payment']);
            }

            // Mail #1 : confirmation de soumission au client
            if ($orderTicket->customer_email) {
                Mail::to($orderTicket->customer_email)
                    ->send(new TicketPaymentSubmittedMail($orderTicket, $payment));
            }

            // Mail admin : nouvelle commande / nouveau paiement soumis
            $adminEmail = config('mail.admin_email') ?? config('mail.from.address');

            if ($adminEmail) {
                Mail::to($adminEmail)->send(
                    new TicketAdminNewOrderMail($orderTicket->fresh(['items','event']), $payment)
                );
            }

            return $payment;
        });
    }

    public function verifyTicketPayment(Payment $payment, int $adminId, ?string $note = null): void {
        DB::transaction(function () use ($payment, $adminId, $note) {

            $payment->refresh();

            // 1. On ne traite que les paiements EN ATTENTE
            if ($payment->status !== Payment::STATUS_SUBMITTED) {
                return;
            }

            $payable = $payment->payable; // morphTo => doit être OrderTicket

            if (!($payable instanceof OrderTicket)) {
                return;
            }

            // 2. Mise à jour du paiement
            $payment->update([
                'status'      => Payment::STATUS_VERIFIED,
                'verified_at' => now(),
                'verified_by' => $adminId,
                'note'        => $note ?? $payment->note,
            ]);

            // 3. On charge les lignes de commande
            $payable->load(['items']); // OrderTicketItem

            foreach ($payable->items as $item) {
                $needed = (int) $item->qty;
                if ($needed <= 0) {
                    continue;
                }

                // 4. On cherche des tickets dispo pour CE type
                $tickets = Ticket::where('ticket_type_id', $item->ticket_type_id)
                    ->where('status', 'available')
                    ->whereNull('order_ticket_id') // important pour éviter de réutiliser un ticket
                    ->lockForUpdate()
                    ->limit($needed)
                    ->get();

                if ($tickets->count() < $needed) {
                    throw new \RuntimeException(
                        "Plus assez de tickets disponibles pour « {$item->ticket_type_name} »."
                    );
                }

                // 5. On assigne les tickets trouvés
                foreach ($tickets as $t) {
                    $t->update([
                        'status'          => 'sold',
                        'order_ticket_id' => $payable->id,
                    ]);
                }
            }

            // 6. Statut commande = payée
            $payable->update([
                'status' => OrderTicket::ST_PAID ?? 'paid',
            ]);

            // 7. Email client : paiement validé
            if ($payable->customer_email) {
                Mail::to($payable->customer_email)
                    ->send(new TicketPaymentVerifiedMail($payable, $payment));
            }
        });
    }

    public function rejectTicketPayment(Payment $payment, int $adminId, ?string $note = null): void {
        DB::transaction(function () use ($payment, $adminId, $note) {

            if ($payment->status !== Payment::STATUS_SUBMITTED) {
                return;
            }

            $payable = $payment->payable;
            if (!($payable instanceof OrderTicket)) {
                return;
            }

            $payment->update([
                'status'      => Payment::STATUS_REJECTED,
                'verified_at' => now(),
                'verified_by' => $adminId,
                'note'        => $note ?? $payment->note,
            ]);

            $payable->update([
                // 'status' => OrderTicket::ST_PAYMENT_REJECTED ?? 'payment_rejected',
                'status' => 'payment_rejected',

            ]);

            if ($payable->customer_email) {
                Mail::to($payable->customer_email)
                    ->send(new TicketPaymentRejectedMail($payable, $payment));
            }
        });
    }


}
