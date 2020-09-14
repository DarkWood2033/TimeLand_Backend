<?php

use Illuminate\Support\Facades\Route;

/* Auth */

Route::prefix('auth')->namespace('Auth')->group(function(){

    Route::middleware('auth:api')->group(function(){

        Route::get('logout', 'LoginController@logout')
            ->name('auth.logout');
        Route::get('refresh', 'LoginController@refresh')
            ->name('auth.refresh');
        // Email verification
        Route::get('email/resend', 'VerificationController@resend')
            ->name('email.resend');
        Route::post('verify', 'VerificationController@verify')
            ->name('email.verify');

    });

    Route::post('login', 'LoginController@login')
        ->name('auth.login');
    Route::post('registration', 'RegisterController@registration')
        ->name('auth.registration');
    // Email verification
    Route::get('verify', 'VerificationController@show')
        ->name('email.show');
    // Forgot password
    Route::post('password/send', 'ForgotPasswordController@sendResetLinkEmail')
        ->name('password.email');
    Route::get('password/reset/{token}', 'ResetPasswordController@show')
        ->name('password.reset');
    Route::post('password/reset', 'ResetPasswordController@reset')
        ->name('password.update');

});


/* Timer */

Route::apiResource('user/timers', 'Timer\TimerController')
    ->names('user.timers')
    ->middleware('auth:api');

/* Support */

Route::post('supports', 'Support\SupportController@store')
    ->name('support.store');
