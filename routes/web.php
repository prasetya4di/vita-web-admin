<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Message\MessageController;
use App\Http\Controllers\Setting\SettingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Data User
    Route::get('/setting', [SettingController::class, 'index'])->name('setting');
    Route::post('/setting', [SettingController::class, 'storeSetting'])->name('setting.store');

    // Data User
    Route::get('/message', [MessageController::class, 'index'])->name('message');
    Route::get('/message/delete/{id}', [MessageController::class, 'deleteMessage'])->name('message.delete');

    // Data User
    Route::get('/data_user', [UserController::class, 'index'])->name('data_user');
    Route::get('/data_user/edit/{id}', [UserController::class, 'fetchUser'])->name('data_user.edit');
    Route::get('/data_user/delete/{id}', [UserController::class, 'deleteUser'])->name('data_user.delete');
    Route::post('/data_user', [UserController::class, 'storeUser'])->name('data_user.store');
});

// Modul Error
Route::get('error_403', function () {
    return view('error.403');
})->name('403');
Route::get('error_404', function () {
    return view('error.404');
})->name('404');

