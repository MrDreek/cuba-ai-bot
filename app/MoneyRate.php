<?php

namespace App;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * App\MoneyRate
 *
 * @property string updated_at
 * @property string value
 * @property int|null|string name
 * @property-read mixed $id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MoneyRate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MoneyRate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MoneyRate query()
 * @mixin \Eloquent
 */
class MoneyRate extends BaseModel
{
    protected $collection = 'money_rate_collection';

    public const MONEY = [
        'CUP_RUB',
        'CUC_RUB',
        'CUP_USD',
        'CUC_USD',
    ];

    public const URL_TEMPLATE = 'http://free.currencyconverterapi.com/api/v5/convert?q=${q}&compact=y';

    private static function saveMoneyRate($rates, $update)
    {
        $rateDb = $update ?: new self;
        foreach ($rates as $item) {
            $key = key($item);
            $rateDb->$key = $item->$key->val;
        }
        $rateDb->updated_at = time();
        $rateDb->save();
    }

    public static function findOrCreate()
    {
        $moneyRate = self::first();
        if ($moneyRate === null) {
            self::updateRate();
        } else if (!$moneyRate->checkValid()) {
            self::updateRate($moneyRate);
        }
    }

    private static function updateRate($update = null)
    {
        foreach (self::MONEY as $item) {
            $url = str_replace(['${q}'], $item, self::URL_TEMPLATE);
            $rates[] = self::curlTo($url);
        }
        if ($rates === null) {
            throw new NotFoundHttpException();
        }
        self::saveMoneyRate($rates, $update);
    }
}
