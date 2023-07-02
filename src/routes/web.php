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
    return view('welcome');
});

Route::get('/home', [AccountController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('home');

Route::prefix('manual-account')->name('account.')->middleware(['auth', 'verified'])->group(function() {
    Route::get('/register', [ManualAccountController::class, 'create']);
    Route::post('/register', [ManualAccountController::class, 'store']);
    Route::get('/register/{id}', [ManualAccountController::class, 'edit'])->name('edit');
    Route::put('/register/{id}', [ManualAccountController::class, 'update'])->name('update');
    Route::delete('/register/{id}', [ManualAccountController::class, 'destory'])->name('delete');
});

Route::prefix('mail-connection')->middleware(['auth', 'verified'])->group(function() {
    Route::get('/register', [MailConnectionController::class, 'create']);
    Route::post('/register', [MailConnectionController::class, 'store']);
    Route::get('/register/{id}', [MailConnectionController::class, 'edit']);
    Route::put('/register/{id}', [MailConnectionController::class, 'update']);
});

require __DIR__.'/auth.php';
