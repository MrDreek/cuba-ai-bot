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
}
