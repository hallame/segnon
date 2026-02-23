<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FaqUpdateRequest extends FormRequest
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
            'question'    => ['sometimes','required','string','max:255'],
            'answer'      => ['sometimes','required','string'],
            'category_id' => ['nullable','exists:categories,id'],
            'position'    => ['nullable','integer','min:0'],
            'active'      => ['sometimes','boolean'],
        ];
    }
}
