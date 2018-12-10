<?php

namespace App;

/**
 * App\Directory
 *
 * @property int|string type
 * @property int|string key
 * @property string value
 * @property-read mixed $id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Directory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Directory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Directory query()
 * @mixin \Eloquent
 */
class Directory extends BaseModel
{
    protected $collection = 'directory_collection';
}
