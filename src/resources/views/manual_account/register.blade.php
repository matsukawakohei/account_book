@extends('adminlte::page')

@section('title', '支出登録')

@section('css')
<style>
    .footer-button {
        width: 100%;
    }
</style>
@stop

@section('content_header')
    <div class="card card-outline card-primary mx-auto" style="width: 40rem;">
        <div class="card-header">
            <h2 class="card-title float-none text-center">
                {{ __('account.manual_account_register') }}
            </h2>
        </div>
        <div class="card-body">
            <form method="post">
                @csrf

                {{-- Name field --}}
                <div class="input-group mb-3 px-5">
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name') }}" placeholder="{{ __('account.name') }}" autofocus>

                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>

                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                {{-- Amount field --}}
                <div class="input-group mb-3 px-5">
                    <input type="text" name="amount" class="form-control @error('amount') is-invalid @enderror"
                            value="{{ old('amount') }}" placeholder="{{ __('account.amount') }}">

                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-yen-sign"></span>
                        </div>
                    </div>

                    @error('amount')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                {{-- Password field --}}
                <div class="input-group mb-4 px-5">
                    <input type="date" name="account_date" class="form-control @error('account_date') is-invalid @enderror">

                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-calendar-alt"></span>
                        </div>
                    </div>

                    @error('account_date')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="row input-group mb-3 px-5 mx-0">
                    {{-- Back button --}}
                    <div class="col-sm-3 p-0">
                        <a href="{{ route('home') }}" class="btn btn-secondary footer-button">
                            戻る
                        </a>
                    </div>
                    <div class="col-sm-6"></div>
                    {{-- Register button --}}
                    <div class="col-sm-3 p-0 text-right">
                        <button type="submit" class="btn btn-primary footer-button">
                            {{ __('adminlte::adminlte.register') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop