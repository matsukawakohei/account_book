@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('css')
<style>
    .month-link {
        cursor: pointer
    }
</style>
@stop

@section('content_top_nav_right')
@if (Route::has('login'))
    <li class="nav-item">
        @auth
        @else
            <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log in</a>

            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="ml-4 mr-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
            @endif
        @endauth
    </li>
@endif
@stop

@section('content_header')
    <div class="row d-flex align-items-center justify-content-center">
        <a href="{{ route('home', ['date' => $aroundDate['before']->toDateString()]) }}" class="col-sm-1 text-right d-flex align-items-center justify-content-end text-dark month-link">
            <h1 class="fas fa-angle-left"></h1>
        </a>
        <div class="m-0 pb-1 text-dark col-sm-2 text-center">
            <h1>{{ $date->format('Y/m') }}</h1>
        </div>
        <a href="{{ route('home', ['date' => $aroundDate['after']->toDateString()]) }}" class="col-sm-1 d-flex align-items-center text-dark month-link">
            <h1 class="fas fa-angle-right"></h1>
        </a>
    </div>
@stop

@section('content')
    @if (session('flash_message'))
        <div class="flash_message bg-success text-center py-3 my-0">
            {{ session('flash_message') }}
        </div>
    @endif
    <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-yen-sign"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">合計金額</span>
                        <h3 class="info-box-number">
                            {{ number_format($sumAmount) }}
                        </h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header border-0">
                <h3 class="card-title">項目別</h3>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-striped table-valign-middle">
                    <thead>
                        <tr>
                            <th>日付</th>
                            <th>項目名</th>
                            <th>金額</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($accounts as $account)
                        <tr>
                            <td>
                                {{ $account->date }}
                            <td>
                                {{ $account->name }}
                            </td>
                            <td>
                                {{ sprintf('%s', number_format($account->amount)) }}
                            </td>
                            <td class="row d-flex align-items-center justify-content-center">
                                <div class="col-sm-2">
                                @if($storeType::from($account->store_type) === $storeType::Mail)
                                    <span class="mr-2"><i class="far fa-envelope"></i></span>
                                @elseif($storeType::from($account->store_type) == $storeType::Manual)
                                    <span class="mr-2"><i class="far fa-edit"></i></span>
                                @else
                                    <span class="mr-2"><i class="fas fa-question"></i></span>
                                @endif
                                </div>
                                <div class="col-sm-2">
                                    <span class="mr-2">
                                        <a href="{{ route('account.edit', ['id' => $account->id]) }}" class="text-muted">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                    </span>
                                </div>
                                <div class="col-sm-2">
                                    <span class="mr-2">
                                        <a href="#" class="text-muted">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </span>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-3 mb-3 row justify-content-center">
                    {{ $accounts->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
@stop
