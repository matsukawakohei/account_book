<?php

return [
    'name'                    => '支出名',
    'amount'                  => '金額',
    'date'                    => '支出日時',
    'manual_account_register' => '支出登録',
    'manual_account_update'   => '支出編集',
    'register_complete'       => '支出の登録が完了しました。',
    'update_complete'         => '支出の更新が完了しました。',
    'delete_complete'         => '支出の削除が完了しました。',
    'invalid_account'         => '無効な明細が選択されました。',
    'errors'                  => [
        'name'    => [
            'string'   => '支出名は文字列形式で入力してください。',
            'max'      => '支出名は最大50文字までです。',
        ],
        'amount'  => [
            'string'   => '金額は数値形式で入力してください。',
            'min'      => '金額は1以上の整数を入力してください。',
        ],
        'date'    => [
            'date'     => '日付は日付形式で入力してください。',
        ]
    ]
];
