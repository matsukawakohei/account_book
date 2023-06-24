@extends('adminlte::page')

@section('title', '明細メール登録')

@section('content_header')
    <div class="card card-outline card-primary mx-auto" style="width: 40rem;">
        <div class="card-header">
            <h2 class="card-title float-none text-center">
                {{ __('mail_connection.mail_connection_register') }}
            </h2>
        </div>
        <div class="card-body">
            <form method="post">
                @csrf

                {{-- Email field --}}
                <div class="input-group mb-3">
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email') }}" placeholder="{{ __('mail_connection.email') }}" autofocus>

                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                {{-- Password field --}}
                <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                        placeholder="{{ __('mail_connection.password') }}">

                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                {{-- MailBox field --}}
                <div class="input-group mb-3">
                    <input type="text" name="mail_box" class="form-control @error('mail_box') is-invalid @enderror"
                        placeholder="{{ __('mail_connection.mail_box') }}">

                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-folder"></span>
                        </div>
                    </div>

                    @error('mail_box')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                {{-- Register button --}}
                <div class="input-group mb-3">
                    <button type="submit" class="btn btn-block btn-flat btn-primary">
                        {{ __('mail_connection.register') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@stop