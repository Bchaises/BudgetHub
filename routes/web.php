<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RecurringTransactionController;
use App\Http\Controllers\TransactionCategoryController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TransferController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('welcome'))->name('home');

// Add 'verified' if you want only users verified
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'show'])->name('dashboard');

    // Routes for transactions between two bank accounts
    Route::prefix('transfer')->controller(TransferController::class)->group(function () {
        Route::get('/', 'index')->name('transfer.index');
        Route::post('/create', 'create')->name('transfer.create');
    });

    // Routes for Transactions
    Route::prefix('transaction')->controller(TransactionController::class)->group(function () {
        Route::get('/', 'index')->name('transaction.index');
        Route::get('/{id}', 'show')->name('transaction.show')->where('id', '[0-9]+');
        Route::post('/', 'store')->name('transaction.store');
        Route::patch('/{id}/edit', 'update')->name('transaction.update');
        Route::delete('/{id}', 'destroy')->name('transaction.destroy');
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
        Route::get('/{id?}', 'show')->name('account.show');
        Route::post('/', 'store')->name('account.store');
        Route::get('/{id}/edit', 'edit')->name('account.edit');
        Route::patch('/{id}/update', 'update')->name('account.update');
        Route::delete('/{id}', 'destroy')->name('account.destroy');
    });

    // Routes for recurring transactions
    Route::prefix('recurring')->controller(RecurringTransactionController::class)->group(function () {
        Route::get('/account/{id}/recurring', 'show')->name('recurring.show');
        Route::post('/', 'store')->name('recurring.store');
        Route::patch('/{id}/edit', 'update')->name('recurring.update');
        Route::delete('/{id}', 'destroy')->name('recurring.destroy');
    });

    // Routes for Profile
    Route::prefix('profile')->controller(ProfileController::class)->group(function () {
        Route::get('/', 'edit')->name('profile.edit');
        Route::patch('/information', 'updateInformation')->name('profile.update.information');
        Route::patch('/email', 'updateEmail')->name('profile.update.email');
        Route::delete('/', 'destroy')->name('profile.destroy');
    });

    // Routes for invitation
    Route::prefix('invitation')->controller(InvitationController::class)->group(function () {
        Route::post('/', 'store')->name('invitation.store');
        Route::delete('/{invitation}', 'destroy')->name('invitation.destroy');
        Route::get('/respond/{token}', [InvitationController::class, 'respond'])->name('invitation.respond');
        Route::get('/respondWithoutToken/{id}', 'respondWithoutToken')->name('invitation.respondWithoutToken');
    });

    // Routes for budget
    Route::prefix('budget')->controller(BudgetController::class)->group(function () {
        Route::post('/', 'store')->name('budget.store');
        Route::delete('/{id}', 'destroy')->name('budget.destroy');
    });
});

require __DIR__.'/auth.php';
