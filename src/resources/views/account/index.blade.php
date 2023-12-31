@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.css" />
<style>
    .month-link {
        cursor: pointer
    }
    .delete-button {
        border: none;
        background-color: transparent;
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
        <a href="{{ route('account.index', ['date' => $aroundDate['before']->toDateString()]) }}" class="col-sm-1 text-right d-flex align-items-center justify-content-end text-dark month-link">
            <h1 class="fas fa-angle-left"></h1>
        </a>
        <div class="m-0 pb-1 text-dark col-sm-2 text-center">
            <h1>{{ $date->format('Y/m') }}</h1>
        </div>
        <a href="{{ route('account.index', ['date' => $aroundDate['after']->toDateString()]) }}" class="col-sm-1 d-flex align-items-center text-dark month-link">
            <h1 class="fas fa-angle-right"></h1>
        </a>
    </div>
@stop

@section('content')
    <x-alert />
    <x-loading-view />
    <div class="row">
        <div class="col-sm-3">
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
        <div class="col-sm-3">
            <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-angle-double-up"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">明細別最高金額</span>
                        <h3 class="info-box-number">
                            {{ number_format($maxAmount) }}
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header border-0">
            <h3 class="card-title">項目別</h3>
        </div>
        <div class="card-body">
            <table id="account-table" class="compact stripe table-bordered">
                <thead>
                    <tr>
                        <th>日付</th>
                        <th>項目名</th>
                        <th class="p-0">
                            <div class="text-center">金額</div>
                        </th>
                        <th>
                            <div class="text-center">種別</div>
                        </th>
                        <th>
                            <div class="text-center">編集</div>
                        </th>
                        <th>
                            <div class="text-center">削除</div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($accounts as $account)
                    <tr>
                        <td>
                            {{ $account->date }}
                        <td class="account-name">
                            {{ $account->name }}
                        </td>
                        <td>
                            <div class="text-right">
                                {{ sprintf('%s', number_format($account->amount)) }}
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center justify-content-center">
                                @if($storeType::from($account->store_type) === $storeType::Mail)
                                    <span><i class="far fa-envelope"></i></span>
                                @elseif($storeType::from($account->store_type) == $storeType::Manual)
                                    <span><i class="far fa-edit"></i></span>
                                @else
                                    <span><i class="fas fa-question"></i></span>
                                @endif
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center justify-content-center">
                                <a href="{{ route('account.edit', $account) }}" class="text-muted">
                                    <i class="fas fa-pen"></i>
                                </a>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center justify-content-center">
                                <form method="post" action="{{ route('account.delete', $account) }}" class="delete-form">
                                    @csrf
                                    @method('delete')
                                    <button type="button" class="delete-button">
                                        <a class="text-muted">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
@stop

@section('js')
@vite('resources/js/account/index.js')
@stop