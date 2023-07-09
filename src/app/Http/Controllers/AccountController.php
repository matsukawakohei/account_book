<?php

namespace App\Http\Controllers;

use App\Enums\StoreType;
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

        return view('home', [
            'accounts'   => $accounts,
            'sumAmount'  => $sumAmount,
            'date'       => $date,
            'aroundDate' => $aroundDate,
            'maxAmount'  => $maxAmount,
            'storeType'  => StoreType::class,
        ]);
    }
}
