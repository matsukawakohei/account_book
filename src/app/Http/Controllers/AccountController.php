<?php

namespace App\Http\Controllers;

use App\Enums\StoreType;
use App\Http\Requests\ManualAccountRequest;
use App\Models\Account;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function index(Request $request)
    {
        $date     = $request->has('date') ? new Carbon($request->date) : new Carbon();
        $start    = $date->copy()->startOfMonth()->toDateString();
        $end      = $date->copy()->endOfMonth()->toDateString();

        $aroundDate = [
            'before' => $date->copy()->subMonthNoOverflow(),
            'after'  => $date->copy()->addMonthNoOverflow(),
        ];

        $accounts = Account::where('user_id', Auth::id())
                        ->whereBetween('date', [$start, $end])
                        ->orderBy('date')
                        ->get();

        $monthAccounts = Account::where('user_id', Auth::id())
                            ->whereBetween('date', [$start, $end])
                            ->get();

        $sumAmount = $monthAccounts->sum('amount');
        $maxAmount = $monthAccounts->max('amount');

        return view('account.index', [
            'accounts'   => $accounts,
            'sumAmount'  => $sumAmount,
            'date'       => $date,
            'aroundDate' => $aroundDate,
            'maxAmount'  => $maxAmount,
            'storeType'  => StoreType::class,
        ]);
    }

    public function create()
    {
        return view('account.create');
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

        return redirect()->route('account.index')->with('success_message', trans('account.register_complete'));
    }

    public function edit(Account $account)
    {
        if (is_null($account) || auth()->id() != $account->user_id) {
            return redirect()->route('account.index')->with('warning_message', trans('account.invalid_account'));
        }

        return view('account.edit', compact('account'));
    }

    public function update(ManualAccountRequest $request, Account $account)
    {
        if (is_null($account) || auth()->id() != $account->user_id) {
            return redirect()->route('account.index')->with('warning_message', trans('account.invalid_account'));
        }

        $account->name    = $request->name;
        $account->amount  = $request->amount;
        $account->date    = $request->account_date;
        $account->save();

        return redirect()->route('account.edit', $account)->with('success_message', trans('account.update_complete'));
    }

    public function destory(Account $account)
    {
        if (is_null($account) || auth()->id() != $account->user_id) {
            return redirect()->route('account.index')->with('warning_message', trans('account.invalid_account'));
        }

        $date = $account->date;
        $account->delete();

        return redirect()->route('account.index', ['date' => $date])->with('success_message', trans('account.delete_complete'));;
    }
}
