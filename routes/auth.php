<?php

use App\Http\Controllers\Auth\RegisteredController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
   Route::get('/register', [RegisteredController::class, 'create'])->name('register');
   Route::post('/register', [RegisteredController::class, 'store']);
});
