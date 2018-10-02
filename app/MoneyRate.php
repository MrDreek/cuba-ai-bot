<?php

namespace App;

/**
 * @property string updated_at
 * @property string value
 * @property int|null|string name
 */
class MoneyRate extends BaseModel
{
    protected $collection = 'money_rate_collection';

    private const MONEY = [
        'CUP_RUB',
        'CUC_RUB',
        'CUP_USD',
        'CUC_USD',
    ];

    public const URL_TEMPLATE = 'http://free.currencyconverterapi.com/api/v5/convert?q=${q}&compact=y';

    private static function saveMoneyRate($rate, $name, $update)
    {
        $rateDb = $update ?: new self;
        $rateDb->name = key($rate);
        $rateDb->value = $rate->$name->val;
        $rateDb->updated_at = time();
        $rateDb->save();
    }

    public static function findOrCreate()
    {
        foreach (self::MONEY as $item) {
            /** @var MoneyRate $obj */
            $obj = static::where('name', $item)->first();
            if ($obj === null) {
                self::getNewRate($item);
            } else if (!$obj->checkValid()) {
                self::getNewRate($item, $obj);
            }
        }
    }

    private static function getNewRate($name, $update = null)
    {
        $url = str_replace(['${q}'], $name, self::URL_TEMPLATE);
        $rate = self::curlTo($url);
        self::saveMoneyRate($rate, $name, $update);
    }
}
