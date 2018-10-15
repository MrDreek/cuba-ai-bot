<?php

namespace App\Http\Controllers;

use App\City;
use App\Http\Requests\RequestIdRequest;
use App\Http\Requests\TourRequest;
use App\Tour;
use Illuminate\Routing\Controller;

class TourController extends Controller
{
    /**
     * Метод возвращает список городов, код ИАТА города и все Аэропорты города с кодами ИАТА аэропортов, или обновляет данные, если они устаревшие
     */
    public function getCity()
    {
        if (City::getCity()) {
            return response()->json(['status' => 'OK']);
        }
    }


    public function search(TourRequest $request)
    {
        return response()->json(['message' => 'Поиск начат', 'requestId' => Tour::startSearch($request->input())]);
    }

    public function check(RequestIdRequest $request)
    {
        $tour = Tour::where('request_id', $request->requestId)->first();
        if ($tour === null) {
            return response()->json(['message' => 'Запрос не найден']);
        }
        return response()->json($tour->checkStatus());
    }

    public function getResult(RequestIdRequest $request)
    {
        $tour = Tour::where('request_id', $request->requestId)->first();
        if ($tour === null) {
            return response()->json(['message' => 'Запрос не найден']);
        }
        return response()->json($tour->getResults());
    }
}
