<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
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
            'name'          => ['required', 'string', 'max:255'],
            'postcode'      => ['nullable', 'string', 'max:20', 'nullable', 'regex:/^\d{3}-\d{4}$/'],
            'address'       => ['nullable', 'string', 'max:255'],
            'profile_image' => ['nullable', 'image', 'max:2048'],
        ];
    }

    public function messages(){
        return [
            'name.required' => 'ユーザー名は必須です。',
            'name.string'   => 'ユーザー名は文字列で入力してください。',
            'name.max'      => 'ユーザー名は255文字以内で入力してください。',

            'postcode.string' => '郵便番号は文字列で入力してください。',
            'postcode.max'    => '郵便番号は20文字以内で入力してください。',
            'postcode.regex'  => '郵便番号は「1234567」または「123-4567」の形式で入力してください。',

            'address.string' => '住所は文字列で入力してください。',
            'address.max'    => '住所は255文字以内で入力してください。',

            'profile_image.image' => 'プロフィール画像は画像ファイルを選択してください。',
            'profile_image.max'   => 'プロフィール画像のサイズは2MB以内にしてください。',
        ];
    }
}
