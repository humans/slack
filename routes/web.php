<?php

Route::middleware('auth')->get('/', function () {
    return view('welcome');
});

Route::resource('login', 'LoginController', [
    'only' => ['create', 'store']
]);

Route::resource('register', 'RegisterController', [
    'only' => ['create', 'store']
]);

Route::get('/login', 'LoginController@create')->name('login.create');
Route::get('/register', 'RegisterController@create')->name('register.create');