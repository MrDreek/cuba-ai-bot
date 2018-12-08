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
    Route::get('get-rate', 'MoneyRateController@getRate')->name('get-rate')->middleware(\Spatie\HttpLogger\Middlewares\HttpLogger::class);
});

Route::prefix('weather')->group(function () {
    Route::post('get-weather', 'WeatherController@getWeather')->name('get-weather')->middleware(\Spatie\HttpLogger\Middlewares\HttpLogger::class);
});

Route::prefix('ticket')->group(function () {
    Route::post('search', 'TicketController@search')->name('search')->middleware(\Spatie\HttpLogger\Middlewares\HttpLogger::class);
    Route::post('check', 'TicketController@checkStatus')->name('check')->middleware(\Spatie\HttpLogger\Middlewares\HttpLogger::class);
    Route::post('get-result', 'TicketController@getResult')->name('get-result')->middleware(\Spatie\HttpLogger\Middlewares\HttpLogger::class);
});

Route::prefix('tour')->group(function () {
    Route::get('get-city', 'TourController@getCity')->name('get-city')->middleware(\Spatie\HttpLogger\Middlewares\HttpLogger::class);
    Route::post('search', 'TourController@search')->name('search')->middleware(\Spatie\HttpLogger\Middlewares\HttpLogger::class);
    Route::post('check', 'TourController@check')->name('check')->middleware(\Spatie\HttpLogger\Middlewares\HttpLogger::class);
    Route::post('get-result', 'TourController@getResult')->name('get-result')->middleware(\Spatie\HttpLogger\Middlewares\HttpLogger::class);
});


Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
Route::get('test', 'TestController@test');
