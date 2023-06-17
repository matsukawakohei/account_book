<?php

return [
    'name'                    => '支出名',
    'amount'                  => '金額',
    'date'                    => '支出日時',
    'manual_account_register' => '支出登録',
    'errors'                  => [
        'name'    => [
            'required' => '支出名は必須入力です。',
            'string'   => '支出名は文字列形式で入力してください。',
            'max'      => '支出名は最大50文字までです。',
        ],
        'amount'  => [
            'required' => '金額は必須入力です。',
            'string'   => '金額は数値形式で入力してください。',
            'min'      => '金額は1以上の整数を入力してください。',
        ],
        'date'    => [
            'required' => '日付は必須入力です。',
            'date'     => '日付は日付形式で入力してください。',
        ]
    ]
];
