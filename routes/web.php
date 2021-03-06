<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/', function () {
    return view('user.dashboard');
})->name("dashboard");

Route::get('/user/register', function () {
    return view('user.register');
})->name("register");

Route::get('/user/validate/{token}', 'UserController@canConfirm')->name("validate");
