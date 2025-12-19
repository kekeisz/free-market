<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'     => ['nullable', 'string', 'max:255'],
            'postcode' => ['required', 'string', 'regex:/^\d{3}-\d{4}$/'],
            'address'  => ['required', 'string', 'max:255'],
            'building' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'postcode.required'  => '郵便番号は必須です。',
            'postcode.regex'     => '郵便番号は 123-4567 の形式で入力してください。',
            'address.required'   => '住所は必須です。',
        ];
    }
}
