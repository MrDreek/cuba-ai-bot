<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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

        if ($exception instanceof NotFoundHttpException) {
            return response()->json([
                'message' => 'Неправильный URL'
            ], 404);
        }

        if ($exception instanceof ModelNotFoundException) {
            return response()->json([
                'message' => $exception->getMessage(),
                'code' => 404
            ], 404);
        }

        return response()->json([
            'message' => 'Не обработанная ошибка',
            'error' => $exception->getMessage()
        ], 500);
    }
}
