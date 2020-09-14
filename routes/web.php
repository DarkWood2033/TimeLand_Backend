<?php

use Illuminate\Support\Facades\Route;

Route::get('test', function (\Illuminate\Http\Request $request){
//    dd($request->);
});

Route::get('localization/load', 'LangController@load')
    ->name('localization.load');

Route::get('/{vue}', function(){
    return view('site.app');
})->where('vue', '^(?!api).*$');
