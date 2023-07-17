<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\ManualAccountController;
use App\Http\Controllers\MailConnectionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('account.index');
});

Route::prefix('account')
    ->middleware('auth')
    ->controller(AccountController::class)
    ->name('account.')
    ->group(function() {
        Route::get('', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::post('', 'store')->name('store');
        Route::get('{account}', 'edit')->name('edit')
            ->whereNumber('account');
        Route::put('{account}', 'update')->name('update')
            ->whereNumber('account');
        Route::delete('{account}', 'destory')->name('delete')
            ->whereNumber('account');
});

Route::prefix('mail-connection')
    ->middleware('auth')
    ->controller(MailConnectionController::class)
    ->name('mail_connection.')
    ->group(function() {
    Route::get('', 'index')->name('index');
    Route::get('/register', 'create')->name('create');
    Route::post('/register', 'store')->name('store');
    Route::get('{mail_connection}', 'edit')->name('edit')
        ->whereNumber('mail_connection');
    Route::put('{mail_connection}', 'update')->name('update')
        ->whereNumber('mail_connection');
    Route::delete('{mail_connection}', 'destroy')->name('delete')
        ->whereNumber('mail_connection');
});

require __DIR__.'/auth.php';
