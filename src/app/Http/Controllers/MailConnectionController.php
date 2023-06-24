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
        $ivlen = openssl_cipher_iv_length(\Config('const.mail_connection.encrypt_tyep'));
        $iv = openssl_random_pseudo_bytes($ivlen);
        $password = openssl_encrypt(
            $request->password,
            \Config('const.mail_connection.encrypt_tyep'),
            \Config('const.mail_connection.encrypt_password'),
            \Config('const.mail_connection.encrypt_options'),
            $iv
        );
        $hmac = hash_hmac('sha256', $password, \Config('const.mail_connection.encrypt_password'), $as_binary=true);
        $ciphertext = base64_encode( $iv.$hmac.$password );
        MailConnection::create([
            'user_id'    => auth()->id(),
            'email'      => $request->email,
            'password'   => $password,
            'ciphertext' => $ciphertext,
            'host'       => \Config('const.mail_connection.host'),
            'port'       => \Config('const.mail_connection.port'),
            'subject'    => \Config('const.mail_connection.subject')
        ]);

        return redirect('/home')->with('flash_message', trans('account.register_complete'));
    }
}
