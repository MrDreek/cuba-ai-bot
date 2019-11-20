<?php
/**
 * Created by PhpStorm.
 * User: mr_dreek
 * Date: 28.09.18
 * Time: 10:32
 */

namespace App\Http\Controllers;

use App\Http\Requests\RequestIdRequest;
use App\Http\Requests\TicketRequest;
use App\Http\Resources\Request as RequestResource;
use App\Request;
use Illuminate\Routing\Controller;

class TicketController extends Controller
{
    public function search(TicketRequest $request)
    {
        if ((int)$request->AD + (int)$request->CN + (int)$request->IN > 8) {
            return response()->json(['message' => 'Максимальное число участков маршрута – 8']);
        }
        return response()->json(Request::createRequest($request));
    }

    public function checkStatus(RequestIdRequest $request)
    {
        $myRequest = Request::where('requestId', (string)$request->requestId)->first();
        return response()->json($myRequest->check());
    }

    public function getResult(RequestIdRequest $request)
    {
        $myRequest = Request::where('requestId', (string)$request->requestId)->first();
        if ($myRequest === null) {
            return response()->json(['messsage' => 'Запрос не найден'], 404);
        }

        if (isset($myRequest->tickets)) {
            return new RequestResource($myRequest);
        }

        $result = $myRequest->getResult();
        if (is_array($result)) {
            return response()->json($result, 200);
        }

        return new RequestResource($myRequest);
    }
}
