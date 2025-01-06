<?php

use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;

Route::get('/menu', [MenuController::class, 'index']);
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/register', [RegisterController::class, 'register'])->name('register');
Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/login', function () {
    return view('login');
})->name('login.page');


Route::get('/order-confirmation.php', [OrderController::class, 'show'])->name('order-confirmation');



