<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentSubmitRequest;
use App\Models\{Order, Payment, PaymentMethod};
use App\Services\PaymentService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\QrCode as EndroidQr;
use App\Services\MonerooPaymentService;

class ShopPaymentController extends Controller {

    public function show(Order $order){
        $sessEmail = (string) (session('user.email') ?? '');
        $sessId    = (int) (session('user.id') ?? 0);
        $lastRef   = session('last_order_reference');

        $hasVerified = $order->payments()->where('status', Payment::STATUS_VERIFIED)->exists();
        if ($hasVerified || (int)$order->status === Order::STATUS_PAID) {
            return redirect()->route('shop.orders.success', $order->reference);
        }

        // Paiement soumis en attente ? -> afficher info et bloquer le formulaire
        $payment = $order->payments()
            ->where('status', Payment::STATUS_SUBMITTED)
            ->latest('id')
            ->first();


        $ok = !$sessEmail
            || strcasecmp($order->customer_email, $sessEmail) === 0
            || ($sessId && $order->user_id === $sessId)
            || ($lastRef && $order->reference === $lastRef);
        abort_unless($ok, 403);

        $methods = PaymentMethod::with(['mobileMoney','bank','cash','card','cod'])
            ->where('active', true)->orderBy('position')->get();
        return view('frontend.shop.payment', compact('order','methods', 'payment'));
    }

    public function pay(PaymentSubmitRequest $request, Order $order, PaymentService $payments) {
        // authorize() a déjà filtré, on ne refait pas de 403 ici
        $payment = $payments->submit($order, [
            'payment_method_id'  => $request->payment_method_id,
            'user_id'          => session('user.id'),
            'transaction_number' => $request->transaction_number,
            'note'               => $request->note,
            'momo_phone'         => $request->momo_phone,
            'momo_name'          => $request->momo_name,
            'momo_operator'      => $request->momo_operator,
        ], $request->file('receipt'));
        session()->put('last_order_reference', $order->reference);

        return redirect()
            ->route('shop.orders.success', $order->reference)
            ->with('success', 'Paiement soumis. En attente de validation.');
    }

    public function payOnline(Request $request, Order $order, MonerooPaymentService $moneroo) {
        // Sécurité basique, comme dans show()
        $sessEmail = (string) (session('user.email') ?? '');
        $sessId    = (int) (session('user.id') ?? 0);
        $lastRef   = session('last_order_reference');

        $ok = !$sessEmail
            || strcasecmp($order->customer_email, $sessEmail) === 0
            || ($sessId && $order->user_id === $sessId)
            || ($lastRef && $order->reference === $lastRef);

        abort_unless($ok, 403);

        if (($order->total ?? 0) <= 0) {
            abort(403, 'Ce paiement ne peut pas être traité (montant nul).');
        }

        // Ici, soit tu utilises les infos déjà sur Order,
        $payment = $moneroo->initForOrder($order); // cf. service juste après

        return redirect()->away($payment->checkout_url);
    }

    public function handleMonerooReturn(Request $request, Order $order, MonerooPaymentService $moneroo) {
        $transactionId = $request->query('transaction_id')
            ?? $request->query('id')
            ?? $order->moneroo_transaction_id;

        if (!$transactionId) {
            return redirect()
                ->route('shop.orders.success', $order->reference)
                ->with('error', 'Référence de paiement introuvable.');
        }

        try {
            $payment = $moneroo->verify($transactionId);
        } catch (\Throwable $e) {
            logger()->error('Moneroo verify error (shop)', [
                'transaction_id' => $transactionId,
                'order_id'       => $order->id,
                'error'          => $e->getMessage(),
            ]);

            return redirect()
                ->route('shop.payment.show', $order)
                ->with('error', 'Impossible de vérifier le paiement pour le moment. Merci de réessayer.');
        }

        $statusRaw = $payment->status ?? null;
        $status    = $statusRaw ? strtolower(trim($statusRaw)) : null;

        logger()->info('Moneroo payment status (shop)', [
            'transaction_id'    => $transactionId,
            'order_id'          => $order->id,
            'status_raw'        => $statusRaw,
            'status_normalized' => $status,
        ]);

        // 1) OK
        if (in_array($status, ['succeeded', 'paid', 'success', 'completed', 'approved'])) {
            // 1) Créer un Payment "auto-validé" pour tracer Moneroo
            $method = PaymentMethod::where('type', 'online')->where('key', 'moneroo')->first();

            $payment = $order->payments()->create([
                'reference'          => 'MON-'.now()->format('Ymd-His').'-'.str()->upper(str()->random(6)),
                'payment_method_id'  => $method?->id,
                'user_id'            => $order->user_id,
                'amount'             => $order->total,
                'currency'           => $order->currency,
                'transaction_number' => $transactionId, // renvoyé par Moneroo
                'status'             => \App\Models\Payment::STATUS_VERIFIED,
                'submitted_at'       => now(),
                'verified_at'        => now(),
                'verified_by'        => null, // PSP donc pas d’admin
                'note'               => 'Paiement confirmé via Moneroo',
            ]);

            // 2) Marquer la commande payée
            $order->update(['status' => Order::STATUS_PAID]);

            return redirect()
                ->route('shop.orders.success', $order->reference)
                ->with('success', 'Paiement confirmé avec succès.');
        }


        // 2) En attente
        if (in_array($status, ['pending', 'processing', 'waiting'])) {
            $order->update(['status' => Order::STATUS_UNDER_REVIEW]);

            return redirect()
                ->route('shop.orders.success', $order->reference)
                ->with('info', 'Votre paiement est en cours de traitement. Vous recevrez une confirmation dès validation.');
        }

        // 3) Échec
        $order->update(['status' => Order::STATUS_PENDING]);

        return redirect()
            ->route('shop.payment.show', $order)
            ->with('error', 'Paiement non confirmé. Vous pouvez réessayer ou choisir un autre moyen de paiement.');
    }



    public function success(string $reference) {
        $order = Order::where('reference',$reference)->firstOrFail();
        return view('frontend.shop.success', compact('order'));
    }

    public function receipt(string $reference) {
        $order = Order::where('reference',$reference)
            ->with(['items.product','items.sku','payments.method'])
            ->firstOrFail();

        $isPaid = $order->payments()->where('status', Payment::STATUS_VERIFIED)->exists();

        // QR (Endroid) -> PNG base64
        $writer = new PngWriter();
        $qr     = EndroidQr::create(route('shop.products.index'))->setSize(140)->setMargin(2);
        $png    = $writer->write($qr)->getString();
        $qrPng  = base64_encode($png);

        $pdf = Pdf::setOptions([
            'isRemoteEnabled' => true,
            'dpi'             => 110,
            'defaultFont'     => 'DejaVu Sans',
        ])->loadView('frontend.shop.receipt', [
            'order'  => $order,
            'qrPng'  => $qrPng,   // <<< même variable que Booking
            'isPaid' => $isPaid,
        ])->setPaper('a4');
        return $pdf->download('receipt-'.$order->reference.'.pdf');
    }
}
