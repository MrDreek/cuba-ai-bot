<?php

namespace App\Http\Controllers;

use App\Http\Requests\NameRequest;
use App\Weather;
use Illuminate\Routing\Controller;
use App\Http\Resources\Weather as WeatherResource;

class WeatherController extends Controller
{
    /**
     * Метод возвращает погоду из базы, или обновляет данные, если они устаревшие
     * @param NameRequest $request
     * @return WeatherResource
     */
    public function getWeather(NameRequest $request)
    {
        $weather = Weather::findOrCreate($request->name);
        return new WeatherResource($weather);
    }
}
