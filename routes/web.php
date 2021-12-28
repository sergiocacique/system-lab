<?php

use App\Http\Controllers\AulaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return redirect()->route('dashboard.index');
});

Route::name('auth.')->prefix('login')->group(function () {
    Route::get('', [AuthController::class, 'index'])->name('index');
    Route::get('create', [AuthController::class, 'create'])->name('create');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('autenticar', [AuthController::class, 'login'])->name('login');
    Route::post('register', [AuthController::class, 'register'])->name('register');
});

Route::name('dashboard.')->prefix('dashboard')->middleware('auth')->group(function () {
    Route::get('', [DashboardController::class, 'index'])->name('index');

    Route::resource('aulas', AulaController::class, ['except' => 'show']);
    Route::post('checkin', [AulaController::class, 'checkin'])->name('aulas.checkin');
});
