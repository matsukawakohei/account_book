<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function index()
    {
        $accounts = [];
        $accountSum = 0;

        return view('home', compact('accounts', 'accountSum'));
    }
}
