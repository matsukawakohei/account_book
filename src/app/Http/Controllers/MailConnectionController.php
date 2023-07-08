<?php

namespace App\Http\Controllers;

use App\Models\MailConnection;
use Illuminate\Http\Request;
use App\Http\Requests\MailConnectionRequest;
use App\Http\Requests\MailConnectionUpdateRequest;
use App\Services\EncryptService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class MailConnectionController extends Controller
{
    public function index(): View
    {
        $mailConnections = MailConnection::where('user_id', auth()->id())->get();

        return view('mail-connection.index', compact('mailConnections'));
    }

    public function create(): View
    {
        return view('mail-connection.register');
    }

    public function store(MailConnectionRequest $request): RedirectResponse
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

        return redirect()->route('mail_connection.index')->with('success_message', trans('mail_connection.register_complete'));
    }

    public function edit(MailConnection $mailConnection): View
    {
        return view('mail-connection.edit', compact('mailConnection'));
    }

    public function update(MailConnectionUpdateRequest $request, MailConnection $mailConnection): RedirectResponse
    {
        $mailConnection->email    = $request->email;

        if ($request->password) {
            $mailConnection->cipher_password = EncryptService::execEncrypt($request->password);
        }

        $mailConnection->mail_box = $request->mail_box ?: \Config('const.mail_connection.default_mail_box');
        $mailConnection->subject  = $request->subject;

        $mailConnection->save();

        return redirect()->route('mail_connection.index')->with('success_message', trans('mail_connection.update_complete'));
    }
}
