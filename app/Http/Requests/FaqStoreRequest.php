<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FaqStoreRequest extends FormRequest
{
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
            'question'    => ['required','string','max:255'],
            'answer'      => ['required','string'],
            'category_id' => ['nullable','exists:categories,id'],
            'position'    => ['nullable','integer','min:0'],
            'active'      => ['sometimes','boolean'],
        ];
    }

    public function validated($key = null, $default = null) {
        $data = parent::validated();
        $data['position'] = $data['position'] ?? 0;
        $data['active']   = $data['active'] ?? true;
        return $data;
    }


}
