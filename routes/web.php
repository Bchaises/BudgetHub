<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionCategoryController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

// Dashboard
Route::get('/', [DashboardController::class, 'show'])->name('dashboard');

// Routes for Transactions
Route::prefix('transaction')->controller(TransactionController::class)->group(function () {
    Route::get('/', 'index')->name('transaction.index');
    Route::get('/{id}', 'show')->name('transaction.show')->where('id', '[0-9]+');
    Route::post('/', 'store')->name('transaction.store');
    Route::patch('/{id}/edit', 'update')->name('transaction.update');
    Route::delete('{id}', 'destroy')->name('transaction.destroy');
});

// Routes for Categories
Route::prefix('transaction/category')->controller(TransactionCategoryController::class)->group(function () {
    Route::get('/', 'index')->name('category.index');
    Route::get('/{id}', 'show')->name('category.show')->where('id', '[0-9]+');
    Route::post('/', 'store')->name('category.store');
    Route::patch('/{id}/edit', 'update')->name('category.update');
    Route::delete('/{id}', 'destroy')->name('category.destroy');
});

// Routes for Accounts
Route::prefix('account')->controller(AccountController::class)->group(function () {
    Route::get('/', 'index')->name('account.index');
    Route::get('/{id}', 'show')->name('account.show');
    Route::post('/', 'store')->name('account.store');
    Route::patch('/{id}/edit', 'update')->name('account.update');
    Route::delete('/{id}', 'destroy')->name('account.destroy');
});
