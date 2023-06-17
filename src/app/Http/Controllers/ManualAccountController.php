<?php

namespace App\Http\Controllers;

use App\Models\ManualAccount;
use App\Http\Requests\ManualAccountRequest;

class ManualAccountController extends Controller
{
    public function create()
    {
        return view('manual_account.register');
    }

    public function store(ManualAccountRequest $request)
    {
        \Log::error('とりあえず来たよ');
        // 現在認証しているユーザーを取得
        \Log::error(auth()->user());

        // 現在認証しているユーザーのIDを取得
        \Log::error(auth()->id());

        ManualAccount::create([
            'user_id' => auth()->id(),
            'name'    => $request->name,
            'amount'  => $request->amount,
            'date'    => $request->account_date,
        ]);

        return view('manual_account.register');
    }

    public function edit(int $id)
    {

    }

    public function update()
    {

    }

    public function destory(int $id)
    {

    }
}
