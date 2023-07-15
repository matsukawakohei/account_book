<?php

return [
    'mail_connection' => [
        'host'             => 'imap.mail.yahoo.co.jp',
        'port'             => 993,
        'subject'          => 'カード利用のお知らせ(本人ご利用分)',
        'default_mail_box' => 'INBOX',
        'encrypt_algo'     => 'sha256',
        'encrypt_tyep'     => 'AES-128-CBC',
        'encrypt_password' => 'password',
        'encrypt_options'  => 0,
    ],
    'mail_account'    => [
        'day_of_payment_word' => '■利用日:',
        'account_name_word'   => '■利用先:',
        'amount_word'         => '■利用金額:',
        'separator'           => ':',
        'value_index'         => 1,
    ]
];