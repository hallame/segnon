<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array {
        return [
            'lastname'  => ['required','string','max:100'],
            'firstname' => ['required','string','max:100'],
            'email'     => ['required','email','max:150'],
            'phone'     => ['required','string','max:30'],

            'shipping_address'          => ['sometimes','array'],
            'shipping_address.line1'    => ['nullable','string','max:255'],
            'shipping_address.city'     => ['nullable','string','max:120'],
            'shipping_address.state'    => ['nullable','string','max:120'],
            'shipping_address.zip'      => ['nullable','string','max:20'],
            'shipping_address.country'  => ['nullable','string','max:120'],

            'note' => ['nullable','string','max:1000'],
        ];
    }
}
