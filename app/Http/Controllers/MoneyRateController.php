<?php
/**
 * Created by PhpStorm.
 * User: mr_dreek
 * Date: 28.09.18
 * Time: 10:32
 */

namespace App\Http\Controllers;

use App\Http\Resources\MoneyRate as MoneyRateResource;
use App\MoneyRate;
use Illuminate\Routing\Controller;

class MoneyRateController extends Controller
{
    /**
     * Метод возвращает курс валют по заданым параметрам из базы, либо получает их с апи, записывает их в базу  и возвращает
     */
    public function getRate()
    {
        MoneyRate::findOrCreate();
        return new MoneyRateResource(MoneyRate::first());
    }
}
