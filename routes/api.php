<?php

use Illuminate\Support\Facades\Route;

Route::post('auth/login', 'Auth\LoginController@login')
    ->name('auth.login');
