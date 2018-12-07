<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed request_id
 * @property mixed link
 */
class Tour extends JsonResource
{
    public static $wrap = '';

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'code' => 200,
            'results' => \App\Tour::where('requestId', $this->request_id)->paginate(3)
        ];
    }
}
