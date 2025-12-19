<?php

return [
    'required' => ':attribute を入力してください。',
    'email' => ':attribute の形式が正しくありません。',
    'min' => [
        'string' => ':attribute は:min文字以上で入力してください。',
    ],

    'attributes' => [
        'name' => 'お名前',
        'email' => 'メールアドレス',
        'password' => 'パスワード',
        'password_confirmation' => '確認用パスワード',
    ],

    'custom' => [
        'name' => [
            'required' => 'お名前を入力してください',
        ],
        'email' => [
            'required' => 'メールアドレスを入力してください',
            'email' => 'メールアドレスを入力してください',
            'unique' => 'このメールアドレスはすでに登録されています。',
        ],
        'password' => [
            'required' => 'パスワードを入力してください',
            'min' => 'パスワードは8文字以上で入力してください',
            'confirmed' => 'パスワードと一致しません',
        ],
        'password_confirmation' => [
            'required' => 'パスワードと一致しません',
        ],
    ],
];
