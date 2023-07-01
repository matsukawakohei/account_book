@extends('adminlte::page')

@section('title', '支出編集')

@section('content_header')
    <x-alert />
    <div class="card card-outline card-primary mx-auto" style="width: 40rem;">
        <div class="card-header">
            <h2 class="card-title float-none text-center">
                {{ __('account.manual_account_update') }}
            </h2>
        </div>
        <div class="card-body">
            <form method="post" action="{{ route('account.update', ['id' => $account->id]) }}">
                @csrf
                {{ method_field('put') }}

                {{-- Name field --}}
                <div class="input-group mb-3 px-5">
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $account->name) }}" placeholder="{{ __('account.name') }}" autofocus>

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
                            value="{{ old('amount', $account->amount) }}" placeholder="{{ __('account.amount') }}">

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

                {{-- Date field --}}
                <div class="input-group mb-3 px-5">
                    <input type="date" name="account_date" class="form-control @error('account_date') is-invalid @enderror"
                      value="{{ old('date', $account->date) }}">

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

                {{-- Register button --}}
                <div class="input-group mb-3 px-5">
                    <button type="submit" class="btn btn-block btn-flat btn-primary">
                        {{ __('adminlte::adminlte.register') }}
                    </button>
                </div>

            </form>
        </div>
    </div>
@stop