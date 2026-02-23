<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentSubmitRequest extends FormRequest {


    public function authorize(): bool {
        $order = $this->route('order'); // {order:reference}
        $sessEmail = (string) (session('client.email') ?? '');
        $sessId    = (int) (session('client.id') ?? 0);
        $lastRef   = session('last_order_reference');

        return !$sessEmail
            || ($order && strcasecmp($order->customer_email, $sessEmail) === 0)
            || ($order && $sessId && $order->client_id === $sessId)
            || ($order && $lastRef && $order->reference === $lastRef);
    }

    public function rules(): array {
        return [
            'payment_method_id' => ['required','exists:payment_methods,id'],
            // 'payment_method_id' => ['required','integer','exists:payment_methods,id,active,1'],

            'receipt'           => ['nullable','file','mimes:jpg,jpeg,png,pdf','max:4096'],
            'transaction_number'=> ['nullable','string','max:120'],
            'note'              => ['nullable','string','max:1000'],
            // champs "momo_*" optionnels si tu veux les stocker plus tard
            'momo_phone'        => ['nullable','string','max:50'],
            'momo_operator'     => ['nullable','string','max:50'],
            'momo_name'     => ['nullable','string','max:50'],

        ];
    }


}
