<?php

return [
  'mail_connection' => [
    'host'             => 'imap.yahoo.co.jp',
    'port'             => 993,
    'subject'          => 'カード利用のお知らせ(本人ご利用分)',
    'encrypt_tyep'     => 'AES-128-CBC',
    'encrypt_password' => 'password',
    'encrypt_options'  => 0
  ],
  'mail_account'    => [
    'search_subject'    => '*ポイント獲得予定月*',
    'element_num'       => 10,
    'body_date_index'   => 0,
    'body_name_index'   => 1,
    'body_amount_index' => 4
  ]
];