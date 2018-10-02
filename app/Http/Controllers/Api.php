<?php

namespace App\Http\Controllers;

use App\City;
use Illuminate\Routing\Controller;

class Api extends Controller
{
    /**
     * Метод подтягивает список городов и перезаписывает их в базу
     */
    public function updateCites()
    {
        $cityList = City::all();

        foreach ($cityList as $item) {
            $item->getData();
        }

        return response()->json([ 'message' => 'OK!'], 200);
    }
}
