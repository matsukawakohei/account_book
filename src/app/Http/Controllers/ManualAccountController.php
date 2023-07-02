<?php

namespace App\Http\Controllers;

use App\Enums\StoreType;
use App\Models\Account;
use App\Http\Requests\ManualAccountRequest;

class ManualAccountController extends Controller
{
    public function create()
    {
        return view('manual_account.register');
    }

    public function store(ManualAccountRequest $request)
    {
        Account::create([
            'user_id'    => auth()->id(),
            'name'       => $request->name,
            'amount'     => $request->amount,
            'date'       => $request->account_date,
            'store_type' => StoreType::Manual
        ]);

        return redirect('/home')->with('success_message', trans('account.register_complete'));
    }

    public function edit(int $id)
    {
        $account = Account::find($id);

        if (is_null($account) || auth()->id() != $account->user_id) {
            return redirect('/home')->with('warning_message', trans('account.invalid_account'));
        }

        return view('manual_account.edit', compact('account'));
    }

    public function update(ManualAccountRequest $request, int $id)
    {
        $account = Account::find($id);

        if (is_null($account) || auth()->id() != $account->user_id) {
            return redirect('/home')->with('warning_message', trans('account.invalid_account'));
        }

        $account->name    = $request->name;
        $account->amount  = $request->amount;
        $account->date    = $request->account_date;
        $account->save();

        return redirect()->route('account.edit', ['id' => $account->id])->with('success_message', trans('account.update_complete'));
    }

    public function destory(int $id)
    {
        $account = Account::find($id);

        if (is_null($account) || auth()->id() != $account->user_id) {
            return redirect('/home')->with('warning_message', trans('account.invalid_account'));
        }

        $date = $account->date;
        $account->delete();

        return redirect()->route('home', ['date' => $date])->with('success_message', trans('account.delete_complete'));;
    }
}
