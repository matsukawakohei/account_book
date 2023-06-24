<?php

namespace App\Services;

class EncryptService
{
    /**
     * 与えらた文字列を暗号化し、
     * 初期化ベクトルとハッシュ値と暗号化された文字列を結合し、
     * base64形式にエンコードする
     * 
     * @param string 暗号化する文字列
     * 
     * @return string base64形式にエンコードされた初期化ベクトルとハッシュ値と暗号化された文字列を結合した文字列
     */
    public static function execEncrypt(string $rawString): string
    {
        $ivlen = openssl_cipher_iv_length(\Config('const.mail_connection.encrypt_tyep'));
        $iv = openssl_random_pseudo_bytes($ivlen);

        $encryptString = openssl_encrypt(
            $rawString,
            \Config('const.mail_connection.encrypt_tyep'),
            \Config('const.mail_connection.encrypt_password'),
            \Config('const.mail_connection.encrypt_options'),
            $iv
        );

        $hmacHash = hash_hmac(
            \Config('const.mail_connection.encrypt_algo'),
            $encryptString,
            \Config('const.mail_connection.encrypt_password'),
            true
        );

        return base64_encode( $iv .$hmacHash .$encryptString);
    }
}