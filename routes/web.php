<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

// Dashboard
Route::get('/', [DashboardController::class, 'show']);

// Routes pour les transactions
Route::prefix('transaction')->controller(TransactionController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/{id}', 'show')->name('show');
    Route::post('/store', 'store')->name('store');
    Route::patch('/update/{id}', 'update')->name('update');
    Route::delete('/delete/{id}', 'delete')->name('delete');
});

// Routes pour les comptes
Route::prefix('account')->controller(AccountController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/{id}', 'show')->name('show');
    Route::post('/store', 'store')->name('store');
    Route::patch('/update/{id}', 'update')->name('update');
    Route::delete('/delete/{id}', 'delete')->name('delete');
});
