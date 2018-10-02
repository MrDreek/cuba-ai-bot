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

    public const URL_TEMPLATE = 'http://free.currencyconverterapi.com/api/v5/convert?q=${q}&compact=y';

    private static function saveMoneyRate($rate, $name, $update)
    {
        $rateDb = $update ?: new self;
        $rateDb->name = key($rate);
        $rateDb->value = $rate->$name->val;
        $rateDb->updated_at = time();
        $rateDb->save();
        return $rateDb;
    }

    public static function findOrCreate($name)
    {
        /** @var MoneyRate $obj */
        $obj = static::where('name', $name)->first();
        if ($obj === null) {
            return self::getNewRate($name);
        }
        if (($obj !== null) && $obj->checkValid()) {
            return $obj;
        }

        return self::getNewRate($name, $obj);
    }

    private static function getNewRate($name, $update = null)
    {
        $url = str_replace(['${q}'], $name, self::URL_TEMPLATE);
        $rate = self::curlTo($url);
        return self::saveMoneyRate($rate, $name, $update);
    }
}
