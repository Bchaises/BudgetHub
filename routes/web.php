<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'show']);

Route::get('/transaction', [TransactionController::class, 'show']);

Route::get('/account', [AccountController::class, 'show']);
Route::post('/account/store', [AccountController::class, 'store']);
Route::delete('/account/delete/{id}', [AccountController::class, 'delete']);
