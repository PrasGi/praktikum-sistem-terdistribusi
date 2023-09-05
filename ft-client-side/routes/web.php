<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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

Route::get('/auth/login', [AuthController::class, 'loginForm'])->name('login.form');
Route::post('/auth/login', [AuthController::class, 'login'])->name('login');
Route::get('/auth/register', [AuthController::class, 'registerForm'])->name('register.form');
Route::post('/auth/register', [AuthController::class, 'register'])->name('register');

Route::middleware('check')->group(function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions');
    Route::post('/transactions', [TransactionController::class, 'pay'])->name('pay');
    Route::post('/transactions/confirm', [TransactionController::class, 'confirm'])->name('confirm');

    Route::get('/finance', [FinanceController::class, 'index'])->name('finance');
    Route::post('/finance', [FinanceController::class, 'add'])->name('finance.add');
    Route::delete('/finance/{id}', [FinanceController::class, 'destroy'])->name('finance.delete');
});
