@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('css')
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
    <h1>明細メールアカウント一覧</h1>
@stop

@section('content')
    <x-alert />
    <x-loading-view />
    <div class="create-button mb-3">
        <a href="{{ route('mail_connection.create') }}" class="btn btn-info">新規登録</a>
    </div>
    <div class="card">
        <div class="card-body table-responsive p-0">
            <table class="table table-striped table-valign-middle">
                <thead>
                    <tr>
                        <th>メールアドレス</th>
                        <th>メールボックス</th>
                        <th>件名</th>
                        <th class="text-center">編集</th>
                        <th class="text-center">削除</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($mailConnections as $mailConnection)
                    <tr>
                        <td class="mail-address">
                            {{ $mailConnection->email }}
                        <td>
                            {{ $mailConnection->mail_box }}
                        </td>
                        <td>
                            {{ $mailConnection->subject }}
                        </td>
                        <td>
                            <div class="d-flex align-items-center justify-content-center">
                                <a href="{{ route('mail_connection.edit', $mailConnection) }}" class="text-muted">
                                    <i class="fas fa-pen"></i>
                                </a>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center justify-content-center">
                                <form method="post" action="{{ route('mail_connection.delete', $mailConnection) }}" class="delete-form">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="delete-button">
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
            {{-- 
            <div class="mt-3 mb-3 row justify-content-center">
                {{ $accounts->appends(request()->query())->links() }}
            </div>
            --}}
        </div>
    </div>
    
@stop

@section('js')
@vite('resources/js/mail-connection/index.js')
@stop