<?php

namespace App\Services;

use App\Models\Account;
use App\Models\Order;
use App\Models\OrderTicket;
use App\Models\Setting;
use Moneroo\Payment as MonerooPayment;

class MonerooPaymentService {

    protected MonerooPayment $client;

    public function __construct() {

        $secretKey = config('services.moneroo.env') === 'live'
        ? config('services.moneroo.secret_live')
        : config('services.moneroo.secret_sandbox');

        $this->client = new MonerooPayment($secretKey);
    }

    public function initForTicket(OrderTicket $orderTicket): object {
        $amount   = (int) round($orderTicket->total);
        // $currency = Setting::where('key', 'currency')->value('value') ?? 'XOF';
        $currency = 'XOF';
        // 1) Nettoyage téléphone -> digits only
        $rawPhone = (string) ($orderTicket->customer_phone ?? '');
        $digits   = preg_replace('/\D+/', '', $rawPhone);

        $customer = [
            'email'      => $orderTicket->customer_email,
            'first_name' => $orderTicket->customer_firstname,
            'last_name'  => $orderTicket->customer_lastname,
        ];

        if ($digits !== '') {
            $customer['phone'] = (int) $digits;
        }

        $paymentData = [
            'amount'      => $amount,
            'currency'    => $currency,
            'description' => 'Paiement #'.$orderTicket->reference,
            'return_url'  => route('payments.moneroo.return', $orderTicket),

            'customer'    => $customer,

            'metadata' => [
                'order_ticket_id' => (string) $orderTicket->id,
                'event_id'        => (string) $orderTicket->event_id,
                'reference'       => $orderTicket->reference,
            ],
        ];

        $payment = $this->client->init($paymentData);

        $transactionId = $payment->transaction_id
            ?? $payment->id
            ?? (is_array($payment) ? ($payment['transaction_id'] ?? $payment['id'] ?? null) : null);

        $orderTicket->moneroo_transaction_id = $transactionId;
        $orderTicket->status                 = 'awaiting_payment';
        $orderTicket->save();
        return $payment;
    }

    public function initForOrder(Order $order): object {
        $amount   = (int) round($order->total);
        // $currency = $order->currency ?? 'XOF';
                $currency = 'XOF';



        $rawPhone = (string) ($order->customer_phone ?? '');
        $digits   = preg_replace('/\D+/', '', $rawPhone);

        $customer = [
            'email'      => $order->customer_email,
            'first_name' => $order->customer_firstname,
            'last_name'  => $order->customer_lastname,
        ];

        if ($digits !== '') {
            $customer['phone'] = (int) $digits;
        }


        $paymentData = [
            'amount'      => $amount,
            'currency'    => $currency,
            'description' => 'Paiement #'.$order->reference,
            'return_url'  => route('shop.orders.moneroo.return', $order),

            'customer'    => $customer,

            'metadata' => [
                'order_id'  => (string) $order->id,
                'reference' => $order->reference,
            ],
        ];

        $payment = $this->client->init($paymentData);

        $transactionId = $payment->transaction_id
            ?? $payment->id
            ?? (is_array($payment) ? ($payment['transaction_id'] ?? $payment['id'] ?? null) : null);

        $order->moneroo_transaction_id = $transactionId;
        $order->save();

        return $payment;
    }


    public function initForShopSubscription( Account $account, string $plan, int $amount, string $billing = 'monthly',  string $currency = 'XOF'  ): object {
        $owner = $account->users()
            ->wherePivot('is_owner', true)
            ->first() ?? $account->users()->first();

        $customer = [
            'email'      => $owner?->email ?? $account->email,
            'first_name' => $owner?->firstname ?? $account->name,
            'last_name'  => $owner?->lastname ?? '',
        ];

        $paymentData = [
            'amount'      => $amount,
            'currency'    => $currency,
            'description' => 'Abonnement '.$plan.' pour '.$account->name,
            'return_url'  => route('partners.shop.subscription.moneroo.return'),
            'customer'    => $customer,
            'metadata'    => [
                'account_id' => (string) $account->id,
                'plan'       => $plan,
                'billing'    => $billing,
                'type'       => 'subscription',
                "country"    => "BJ",
            ],
        ];

        $payment = $this->client->init($paymentData);

        // tu peux stocker l’ID de transaction sur l’account si tu veux
        $transactionId = $payment->transaction_id
            ?? $payment->id
            ?? (is_array($payment) ? ($payment['transaction_id'] ?? $payment['id'] ?? null) : null);

        $account->moneroo_subscription_transaction_id = $transactionId ?? null;
        $account->save();

        return $payment;
    }


    public function verify(string $transactionId): object {
        return $this->client->verify($transactionId);
    }
}



