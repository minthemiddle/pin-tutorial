<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('root')->middleware('pin');

Route::get('pin/create', function () {
    return view('create');
})->name('pin.create');

Route::post('pin/store', 'PinController@store')->name('pin.store')->middleware('throttle:3,1');
