<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class MoneyRates extends ResourceCollection
{
    public static $wrap = '';

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return $this->collection->map(static function ($resource) {
            return [$resource->name => $resource->value];
        })->all();
    }
}
