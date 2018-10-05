<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [];

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $exception
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function render($request, Exception $exception): \Symfony\Component\HttpFoundation\Response
    {
        if ($exception instanceof ValidationException) {
            $error = [];
            foreach ($exception->validator->errors()->getMessages() as $key => $message) {
                $error[$key] = implode(', ', $message);
            }
            return response()->json([
                'error' => $error
            ], 400);
        }

        return response()->json([
            'message' => 'Не обработанная ошибка',
            'error' => $exception
        ], 500);
    }
}
