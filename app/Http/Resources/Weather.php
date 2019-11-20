<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed temp
 * @property mixed feels_like
 * @property mixed temp_water
 * @property mixed icon
 * @property mixed source
 * @property mixed obs_time
 * @property mixed season
 * @property mixed polar
 * @property mixed daytime
 * @property mixed soil_moisture
 * @property mixed soil_temp
 * @property mixed uv_index
 * @property mixed humidity
 * @property mixed pressure_pa
 * @property mixed pressure_mm
 * @property mixed wind_dir
 * @property mixed wind_gust
 * @property mixed wind_speed
 * @property mixed condition
 */
class Weather extends JsonResource
{
    public static $wrap = '';

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'temp' => $this->temp,
            'feels_like' => $this->feels_like,
            'temp_water' => $this->temp_water,
            'icon' => $this->icon,
            'condition' => $this->condition,
            'wind_speed' => $this->wind_speed,
            'wind_gust' => $this->wind_gust,
            'wind_dir' => $this->wind_dir,
            'pressure_mm' => $this->pressure_mm,
            'pressure_pa' => $this->pressure_pa,
            'humidity' => $this->humidity,
            'uv_index' => $this->uv_index,
            'soil_temp' => $this->soil_temp,
            'soil_moisture' => $this->soil_moisture,
            'daytime' => $this->daytime,
            'polar' => $this->polar,
            'season' => $this->season,
            'obs_time' => $this->obs_time,
            'source' => $this->source
        ];
    }
}
