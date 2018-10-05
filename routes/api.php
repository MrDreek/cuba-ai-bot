<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::prefix('money')->group(function () {
    Route::get('get-rate','MoneyRateController@getRate')->name('get-rate');
});

Route::prefix('weather')->group(function () {
    Route::post('get-weather','WeatherController@getWeather')->name('get-weather');
});

Route::prefix('ticket')->group(function () {
    Route::post('search','TicketController@search')->name('search');
    Route::post('check','TicketController@checkStatus')->name('check');
    Route::post('get-result','TicketController@getResult')->name('get-result');
});
