<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed name
 * @property mixed value
 */
class MoneyRate extends JsonResource
{
    public static $wrap = '';

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        $moneyRates = [];
        foreach (\App\MoneyRate::MONEY as $item) {
            $moneyRates[$item] = $this->$item;
        }
        return $moneyRates;
    }
}
