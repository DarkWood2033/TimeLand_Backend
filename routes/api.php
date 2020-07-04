<?php

use Illuminate\Support\Facades\Route;

/* Auth */

Route::prefix('auth')->namespace('Auth')->group(function(){

    Route::middleware('auth:api')->group(function(){

        Route::get('logout', 'LoginController@logout')
            ->name('auth.logout');
        Route::get('refresh', 'LoginController@refresh')
            ->name('auth.refresh');

    });

    Route::post('login', 'LoginController@login')
        ->name('auth.login');
    Route::post('registration', 'RegisterController@registration')
        ->name('auth.registration');

});
