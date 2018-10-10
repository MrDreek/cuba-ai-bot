<?php

namespace App;

/**
 * @property mixed location
 * @property  mixed name
 * @property  mixed iata
 * @method static where(string $string, $departure_city)
 */
class City extends BaseModel
{
    protected $collection = 'cities_collection';

    public static function getRouteName($sa)
    {
        $cities = explode(',', $sa);

        $routeName = [];
        foreach ($cities as $city) {
            $routeName[] = self::where('iata', $city)->first()->name ?? $city;
        }

        return implode(',', $routeName);
    }
}
