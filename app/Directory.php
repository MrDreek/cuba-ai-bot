<?php

namespace App;

/**
 * @property int|string type
 * @property int|string key
 * @property string value
 */
class Directory extends BaseModel
{
    protected $collection = 'directory_collection';
}
