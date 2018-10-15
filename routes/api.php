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

Route::prefix('tour')->group(function () {
    Route::get('get-city','TourController@getCity')->name('get-city');
    Route::post('search','TourController@search')->name('search');
    Route::post('check','TourController@check')->name('check');
    Route::post('get-result','TourController@getResult')->name('get-result');
});
