<?php

namespace App;

/**
 * App\Weather
 *
 * @property string          value
 * @property int|null|string name
 * @property-read mixed      $id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Weather newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Weather newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Weather query()
 * @mixin \Eloquent
 */
class Weather extends BaseModel
{
    protected $collection = 'weather_collection';

    private const URL_WEATHER = 'https://api.weather.yandex.ru/v1/forecast?lat=${lat}&lon=${lon}&limit=2&hours=false&extra=false';

    private static function getWeather($name, $update = null): Weather
    {
        $city = City::where('name', $name)->firstOrFail();
        $url = str_replace(
            ['${lat}', '${lon}'],
            [
                $city->location['latitude'],
                $city->location['longitude']
            ],
            self::URL_WEATHER
        );
        return self::saveWeather(self::curlTo($url, true)->fact, $name, $update);
    }

    public static function findOrCreate($name): Weather
    {
        /** @var Weather $obj */
        $obj = static::where('name', $name)->first();
        if ($obj === null) {
            return self::getWeather($name);
        }
        if ($obj->checkValid()) {
            return $obj;
        }

        return self::getWeather($name, $obj);
    }

    private static function saveWeather($weather, $name, $update): Weather
    {
        $weatherDb = $update ?: new self;
        $weatherDb->name = $name;
        $weatherDb->updated_at = time();

        $formattedWeather = self::replacer($weather);

        foreach ($formattedWeather as $key => $item) {
            $weatherDb->{$key} = $item;
        }

        $weatherDb->save();
        return $weatherDb;
    }

    private static function replacer($fact)
    {
        $directories = Directory::all();
        foreach ($directories as $item) {
            $key = $item->type;
            if (isset($fact->$key)) {
                $fact->$key = $item->key === $fact->$key ? $item->value : $fact->$key;
            }
        }
        return $fact;
    }
}
