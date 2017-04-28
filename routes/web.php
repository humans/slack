<?php

Route::domain(env('APP_DOMAIN'))->group(function () {
    Route::get('/', 'LandingPageController')->name('landing');
});

// Multi-tenancy
Route::domain('{team}.' . env('APP_DOMAIN'))->group(function () {
    Route::resource('login', 'LoginController', [
        'only' => ['create', 'store']
    ]);

    Route::resource('register', 'RegisterController', [
        'only' => ['create', 'store']
    ]);

    Route::get('/login', 'LoginController@create')->name('login.create');
    Route::get('/register', 'RegisterController@create')->name('register.create');


    Route::middleware('auth')->group(function () {
        Route::get('/', 'AppController')->name('home');
        Route::get('/messages/{channel}', 'AppController')->name('app');
    });
});
