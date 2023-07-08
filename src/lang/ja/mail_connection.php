<?php

return [
    'mail_connection_register' => '明細メール受信アドレス登録',
    'mail_connection_edit'     => '明細メール受信アドレス編集',
    'email'                    => 'メールアドレス',
    'password'                 => 'メールアドレスのパスワード',
    'mail_box'                 => 'メールボックス名',
    'subject'                  => '件名',
    'register'                 => '登録する',
    'register_complete'        => '明細メール受信アドレスの登録が完了しました。',
    'update_complete'          => '明細メール受信アドレスの更新が完了しました。',
    'delete_complete'          => '明細メール受信アドレスの削除が完了しました。',
    'errors' => [
    'email'    => [
        'required' => 'メールアドレスは必須入力です。',
        'string'   => 'メールアドレスは文字列形式で入力してください。',
        'email'    => 'メールアドレスの形式で入力してください。'
    ],
    'password' => [
        'required' => 'メールアドレスのパスワードは必須入力です。',
        'string'   => 'メールアドレスのパスワードは文字列形式で入力してください。'
    ],
    'mail_box' => [
        'string'   => 'メールボックス名は文字列形式で入力してください。',
        'regex'    => 'メールボックス名はアルファベットのみ有効です。'
    ],
    'subject'  => [
        'required' => '件名は必須入力です。',
        'string'   => '件名は文字列形式で入力してください。'
    ]
]
];