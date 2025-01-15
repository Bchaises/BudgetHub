<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionCategoryController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

// Dashboard
Route::get('/', [DashboardController::class, 'show'])->name('dashboard');

// Routes pour les transactions
Route::prefix('transaction')->controller(TransactionController::class)->group(function () {
    Route::get('/', 'index')->name('transaction.index');
    Route::get('/{id}', 'show')->name('transaction.show')->where('id', '[0-9]+');
    ;
    Route::post('/store', 'store')->name('transaction.store');
    Route::patch('/update/{id}', 'update')->name('transaction.update');
    Route::delete('/delete/{id}', 'destroy')->name('transaction.delete');
});

// Routes pour les categories
Route::prefix('transaction/category')->controller(TransactionCategoryController::class)->group(function () {
    Route::get('/', 'index')->name('transaction.category.index');
    Route::get('/{id}', 'show')->name('transaction.category.show')->where('id', '[0-9]+');
    Route::post('/store', 'store')->name('transaction.category.store');
    Route::patch('/update/{id}', 'update')->name('transaction.category.update');
    Route::delete('/delete/{id}', 'destroy')->name('transaction.category.delete');
});

// Routes pour les comptes
Route::prefix('account')->controller(AccountController::class)->group(function () {
    Route::get('/', 'index')->name('account.index');
    Route::get('/{id}', 'show')->name('account.show');
    Route::post('/store', 'store')->name('account.store');
    Route::patch('/update/{id}', 'update')->name('account.update');
    Route::delete('/delete/{id}', 'destroy')->name('account.delete');
});
