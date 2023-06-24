<?php

namespace App\Services;

class DecryptService
{
    const START_INDEX = 0;

    const SHA256_BIT_LENGTH = 32;

    /**
     * 初期化ベクトルとハッシュ値と暗号化された文字列を結合し、
     * base64形式にエンコードされた文字列を復号する
     * 
     * @ param string $cipherString 初期化ベクトルとハッシュ値と暗号化された文字列を結合してbase64形式にエンコードされた文字列
     */
    public static function execDecrypt(string $cipherString): string
    {
        $ivlen = openssl_cipher_iv_length(\Config('const.mail_connection.encrypt_tyep'));
        $decodeCipherString = base64_decode($cipherString);
        $iv = substr($decodeCipherString, self::START_INDEX, $ivlen);
        $cipherStringRaw = substr($decodeCipherString, $ivlen + self::SHA256_BIT_LENGTH);
        return openssl_decrypt(
            $cipherStringRaw,
            \Config('const.mail_connection.encrypt_tyep'),
            \Config('const.mail_connection.encrypt_password'),
            \Config('const.mail_connection.encrypt_options'),
            $iv
        );
    }
}