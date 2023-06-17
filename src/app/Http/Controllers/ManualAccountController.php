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
        ManualAccount::create([
            'user_id' => auth()->id(),
            'name'    => $request->name,
            'amount'  => $request->amount,
            'date'    => $request->account_date,
        ]);

        return redirect('/home')->with('flash_message', trans('account.register_complete'));
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
