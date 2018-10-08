<?php

namespace App;

/**
 * @property mixed AC
 * @property mixed AT
 * @property array|mixed to
 * @property array|mixed from
 * @property int|string requestId
 */
class Ticket extends BaseModel
{
    protected $collection = 'tickets_collection';

    protected $hidden = ['_id', 'requestId'];
}
