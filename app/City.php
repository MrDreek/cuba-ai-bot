<?php

namespace App;

/**
 * App\City
 *
 * @property mixed       location
 * @property mixed       name
 * @property mixed       iata
 * @property array|mixed airports
 * @method static where(string $string, $departure_city)
 * @property-read mixed  $id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\City newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\City newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\City query()
 * @mixin \Eloquent
 */
class City extends BaseModel
{
    protected $collection = 'cities_collection';

    private const CITIES_URL = 'https://api.level.travel/references/airports';

    public static function getCity(): bool
    {
        $response = self::curlToWithTourHeaders(self::CITIES_URL);

        foreach ($response->airports as $airport) {
            self::saveAirportAndCity($airport);
        }
        return true;
    }

    private static function saveAirportAndCity($airport): void
    {
        $cityIata = $airport->city->iata;

        $city = self::where('iata', $cityIata)->first();

        /** @var $city City */
        if ($city !== null) {
            $airports = $city->airports;
            unset($airport->city);

            $airports[] = $airport;

            $city->airports = $airports;
            $city->save();

        } else {
            $city = new self;
            unset($airport->city->id, $airport->id);

            foreach ($airport->city as $key => $item) {
                $city->$key = $item;
            }

            unset($airport->city);
            $city->airports = [$airport];
            $city->save();
        }
    }

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
