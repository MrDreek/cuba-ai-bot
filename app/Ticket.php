<?php

namespace App;

/**
 * App\Ticket
 *
 * @property mixed AC
 * @property mixed AT
 * @property array|mixed to
 * @property array|mixed from
 * @property int|string requestId
 * @property-read mixed $id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ticket newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ticket newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ticket query()
 * @mixin \Eloquent
 */
class Ticket extends BaseModel
{
    protected $collection = 'tickets_collection';

    protected $hidden = ['_id', 'requestId'];
}
