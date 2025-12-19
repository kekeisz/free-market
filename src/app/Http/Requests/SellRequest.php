<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SellRequest extends FormRequest
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
            'name'         => ['required', 'string', 'max:255'],
            'description'  => ['nullable', 'string', 'max:2000'],
            'price'        => ['required', 'integer', 'min:1'],
            'condition_id' => ['required', 'integer', 'exists:conditions,id'],
            'categories'   => ['nullable', 'array'],
            'categories.*' => ['integer', 'exists:categories,id'],
            'image'        => ['nullable', 'image', 'mimes:jpeg,png', 'max:2048'],
        ];
    }

    public function messages()
    {
        return [
            'name.required'         => '商品名は必須です。',
            'name.string'           => '商品名は文字列で入力してください。',
            'name.max'              => '商品名は255文字以内で入力してください。',
            'description.string'    => '商品説明は文字列で入力してください。',
            'description.max'       => '商品説明は2000文字以内で入力してください。',
            'price.required'        => '価格は必須です。',
            'price.integer'         => '価格は整数で入力してください。',
            'price.min'             => '価格は1円以上で入力してください。',
            'condition_id.required' => '商品の状態を選択してください。',
            'condition_id.exists'   => '選択された状態は存在しません。',
            'categories.array'      => 'カテゴリの形式が不正です。',
            'categories.*.exists'   => '選択されたカテゴリの一部が存在しません。',
            'image.image'           => '商品画像は画像ファイルを選択してください。',
            'image.mimes'           => '商品画像はJPEGまたはPNG形式でアップロードしてください。',
            'image.max'             => '商品画像のサイズは2MB以内にしてください。',
        ];
    }
}
