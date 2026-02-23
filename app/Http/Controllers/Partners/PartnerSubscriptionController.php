<?php

namespace App\Http\Controllers\Partners;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Services\MonerooPaymentService;
use App\Support\CurrentAccount;
use Illuminate\Http\Request;

class PartnerSubscriptionController extends Controller {


    public function index(Request $request, CurrentAccount $ctx) {
        $account = $ctx->get();

        return view('backend.shop.subscription', compact('account'));
    }

    public function startSubscription(Request $request, CurrentAccount $ctx, MonerooPaymentService $moneroo) {
        $account = $ctx->get();

        $plan = $request->query('plan', Account::PLAN_STANDARD);       // standard | premium
        $billing = $request->query('billing', 'monthly');              // monthly | annual

        $amount = match ([$plan, $billing]) {
            [Account::PLAN_STANDARD, 'monthly'] => 3500,
            [Account::PLAN_STANDARD, 'annual']  => 35000,
            [Account::PLAN_PREMIUM,  'monthly'] => 9900,
            [Account::PLAN_PREMIUM,  'annual']  => 99000,
            default                            => 0,
        };

        abort_if($amount <= 0, 400);

        $payment = $moneroo->initForShopSubscription($account, $plan, $amount, $billing);

        return redirect()->away($payment->checkout_url);
    }




    // public function startSubscription(Request $request, CurrentAccount $ctx, MonerooPaymentService $moneroo) {
    //     $account = $ctx->get();
    //     $plan = $request->query('plan', Account::PLAN_STANDARD);
    //     $amount = match ($plan) {
    //         Account::PLAN_STANDARD => 3500,
    //         Account::PLAN_PREMIUM  => 9900,
    //         default                => 0,
    //     };

    //     abort_if($amount <= 0, 400);

    //     $payment = $moneroo->initForShopSubscription($account, $plan, $amount);
    //     return redirect()->away($payment->checkout_url);
    // }

    public function handleMonerooReturn(Request $request, MonerooPaymentService $moneroo) {

        $transactionId = $request->query('transaction_id') ?? $request->query('id');
        abort_unless($transactionId, 400);

        $payment = $moneroo->verify($transactionId);

        $statusRaw = $payment->status ?? null;
        $status    = $statusRaw ? strtolower(trim($statusRaw)) : null;

        // metadata peut être un objet ou un tableau selon la lib
        $metadata  = $payment->metadata ?? null;
        if (is_array($metadata)) {
            $accountId = $metadata['account_id'] ?? null;
            $plan      = $metadata['plan']       ?? null;
            $billing   = $metadata['billing']    ?? 'monthly';
        } else {
            $accountId = $metadata->account_id ?? null;
            $plan      = $metadata->plan       ?? null;
            $billing   = $metadata->billing    ?? 'monthly';
        }

        $account = $accountId ? Account::find($accountId) : null;
        abort_unless($account && $plan, 404);

        // ✅ Paiement OK
        if (in_array($status, ['succeeded','paid','success','completed','approved'])) {

            // Durée selon billing
            $nextEnd = $billing === 'annual'
                ? now()->addYear()
                : now()->addMonth();

            $account->update([
                'subscription_plan'    => $plan,
                'on_trial'             => false,
                'subscription_ends_at' => $nextEnd,
            ]);

            return redirect()
                ->route('partners.shop.dashboard')
                ->with('success', 'Votre abonnement a été activé avec succès.');
        }

        // ❌ Paiement pas confirmé
        return redirect()
            ->route('partners.shop.dashboard')
            ->with('error', 'Le paiement de l’abonnement n’a pas été confirmé.');
    }

}
