<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleController;


Route::get('/', function () {
    return view('layout.welcome');
});
Route::get('hello', function () {
    return view('layout.hello');
});
Route::get('home', function () {
    return view('layout.home');
});
// Đăng ký các route cho Google OAuth
Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('google.login');
Route::get('/auth/google/callback', [GoogleController::class, 'callback']);