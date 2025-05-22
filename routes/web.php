<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginRegisterController;
use App\Http\Controllers\PostController;

Route::controller(LoginRegisterController::class)->group(function() {
    Route::get('/register', 'register')->name('register');
    Route::post('/register', 'store')->name('store');
    Route::get('/', 'login')->name('login');
    Route::post('/authenticate', 'authenticate')->name('authenticate');
    Route::get('/home', 'home')->name('home');
    Route::get('/changepassword', 'changepassword')->name('change-password');
    Route::post('/changepassword', 'updatepassword')->name('update-password');
    Route::post('/logout', 'logout')->name('logout');    
});

Route::post('/posts', [PostController::class, 'store'])->name('posts');