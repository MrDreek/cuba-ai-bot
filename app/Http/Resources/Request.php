<?php

namespace App\Http\Resources;

use App\Ticket;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed requestId
 * @property mixed link
 */
class Request extends JsonResource
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
            'link' => $this->link,
            'code' => 200,
            'results' => Ticket::where('requestId', $this->requestId)->paginate(3)
        ];
    }
}
