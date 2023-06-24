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
    'encrypt_options'  => 0
  ],
  'mail_account'    => [
    'target_start_body'             => '*ポイント獲得予定月*',
    'target_end_body'               => 'ショッピングご利用分合計金額',
    'after_name_value_master'       => '本人',
    'after_name_value_not_master'   => '家族',
    'body_date_index'               => 0,
    'body_name_start_index'         => 1,
    'body_amount_index_from_master' => 2
  ]
];