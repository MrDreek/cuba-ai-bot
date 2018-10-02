<?php

namespace App;

/**
 * @property mixed location
 * @property  mixed airport
 * @property mixed nameRus
 * @property  mixed name
 */
class City extends BaseModel
{
    protected $collection = 'cities_collection';

    private const DATA_URL = 'https://api.sandbox.amadeus.com/v1.2/airports/nearest-relevant?apikey=${key}&latitude=${latitude}&longitude=${longitude}';

    public function getData(): void
    {
        $key = config('app.amadeus_key');
        $url = str_replace(['${key}', '${longitude}', '${latitude}'], [$key, $this->location['longitude'], $this->location['latitude']], self::DATA_URL);

        $response = self::curlTo($url);
        $this->airport = [
            'code' => $response[0]->airport,
            'airport_name' => $response[0]->airport_name
        ];

        $this->save();
    }
}
