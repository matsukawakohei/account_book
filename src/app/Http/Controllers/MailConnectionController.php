<?php

namespace App\Http\Controllers;

use App\Models\MailConnection;
use Illuminate\Http\Request;
use App\Http\Requests\MailConnectionRequest;

class MailConnectionController extends Controller
{
    public function create()
    {
        return view('mail-connection.register');
    }

    public function store(MailConnectionRequest $request)
    {
        // 暗号化方式に応じたIV(初期化ベクトル)に必要な長さを取得
        $ivLength = openssl_cipher_iv_length(\Config('const.mail_connection.encrypt_tyep'));
        // IV を自動生成
        $iv = openssl_random_pseudo_bytes($ivLength);
        MailConnection::create([
            'user_id' => auth()->id(),
            'email'   => $request->email,
            'password' => openssl_encrypt(
                $request->password,
                \Config('const.mail_connection.encrypt_tyep'),
                \Config('const.mail_connection.encrypt_password'),
                \Config('const.mail_connection.encrypt_options'),
                $iv
            ),
            'host'     => \Config('const.mail_connection.host'),
            'port'     => \Config('const.mail_connection.port'),
            'subject'  => \Config('const.mail_connection.subject')
        ]);

        return redirect('/home')->with('flash_message', trans('account.register_complete'));
    }
}
