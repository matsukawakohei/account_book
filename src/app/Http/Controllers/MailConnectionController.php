<?php

namespace App\Http\Controllers;

use App\Models\MailConnection;
use Illuminate\Http\Request;
use App\Http\Requests\MailConnectionRequest;
use App\Services\EncryptService;

class MailConnectionController extends Controller
{
    public function create()
    {
        return view('mail-connection.register');
    }

    public function store(MailConnectionRequest $request)
    {
        $ciphertext = EncryptService::execEncrypt($request->password);
        MailConnection::create([
            'user_id'         => auth()->id(),
            'email'           => $request->email,
            'cipher_password' => $ciphertext,
            'mail_box'        => $request->mail_box ? $request->mail_box : \Config('const.mail_connection.default_mail_box'),
            'host'            => \Config('const.mail_connection.host'),
            'port'            => \Config('const.mail_connection.port'),
            'subject'         => $request->subject
        ]);

        return redirect('/home')->with('flash_message', trans('account.register_complete'));
    }
}
