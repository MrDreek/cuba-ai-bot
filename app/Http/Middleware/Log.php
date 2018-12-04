<?php
/**
 * Created by PhpStorm.
 * User: mr_dreek
 * Date: 03.12.18
 * Time: 10:35
 */

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Spatie\HttpLogger\LogProfile;

class Log implements LogProfile
{

    public function shouldLogRequest(Request $request): bool
    {
        return \in_array(strtolower($request->method()), ['get', 'post', 'put', 'patch', 'delete']);
    }
}
