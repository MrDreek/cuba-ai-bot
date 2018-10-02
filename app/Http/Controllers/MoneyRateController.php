<?php
/**
 * Created by PhpStorm.
 * User: mr_dreek
 * Date: 28.09.18
 * Time: 10:32
 */

namespace App\Http\Controllers;

use App\Http\Requests\MoneyRateRequest;
use App\MoneyRate;
use Illuminate\Routing\Controller;
use App\Http\Resources\MoneyRate as MoneyRateResource;

class MoneyRateController extends Controller
{
    /**
     * Метод возвращает курс валют по заданым параметрам из базы, либо получает их с апи, записывает их в базу  и возвращает
     * @param MoneyRateRequest $request
     * @return MoneyRateResource
     */
    public function getRate(MoneyRateRequest $request)
    {
        $name = $request->from . '_' . $request->to;
        $rate = MoneyRate::findOrCreate($name);
        return new MoneyRateResource($rate);
    }
}
