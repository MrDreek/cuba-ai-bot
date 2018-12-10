<?php

namespace App;

use Ixudra\Curl\Facades\Curl;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

/**
 * App\BaseModel
 *
 * @property mixed updated_at
 * @property-read mixed $id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel query()
 * @mixin \Eloquent
 */
class BaseModel extends Eloquent
{
    public const TWELVE_HOURS_IN_SECONDS = 43200;

    public $timestamps = false;

    protected static function curlTo($url, $yandexHeader = false)
    {
        $response = Curl::to($url);

        if ($yandexHeader) {
            $key = config('app.yandex_weather_key');
            $response = $response->withHeader("X-Yandex-API-Key: $key");
        }

        // если нужен прокси
        if (config('app.proxy')) {
            $response = $response->withProxy(config('app.proxy_url'), config('app.proxy_port'), config('app.proxy_type'), config('app.proxy_username'), config('app.proxy_password'));
        }

        return json_decode($response->get());
    }

    protected static function curlToWithTourHeaders($url)
    {
        $response = Curl::to($url);

        $key = config('app.level_travel');
        $response = $response->withHeader('Accept: application/vnd.leveltravel.v3');
        $response = $response->withHeader('Authorization: Token token="' . $key . '"');


        // если нужен прокси
        if (config('app.proxy')) {
            $response = $response->withProxy(config('app.proxy_url'), config('app.proxy_port'), config('app.proxy_type'), config('app.proxy_username'), config('app.proxy_password'));
        }

        return json_decode($response->get());
    }

    protected static function xmlGet($url)
    {
        $response = Curl::to($url);

        // если нужен прокси
        if (config('app.proxy')) {
            $response = $response->withProxy(config('app.proxy_url'), config('app.proxy_port'), config('app.proxy_type'), config('app.proxy_username'), config('app.proxy_password'));
        }

        return json_decode(json_encode(simplexml_load_string($response->get())));
    }

    /**
     * Если текущее время минус время прошлой записи меньше 12 часов, то запись валидная
     * @return bool
     */
    public function checkValid(): bool
    {
        return time() - $this->updated_at < self::TWELVE_HOURS_IN_SECONDS;
    }
}
