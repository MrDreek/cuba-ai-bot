<?php

namespace App\Exceptions;


use Symfony\Component\HttpKernel\Exception\HttpException;

class MyRuntimeException extends HttpException
{
    /**
     * @param  string      $message   The internal exception message
     * @param  \Throwable  $previous  The previous exception
     * @param  int         $code      The internal exception code
     * @param  array       $headers
     */
    public function __construct(string $message = null, \Throwable $previous = null, int $code = 0, array $headers = [])
    {
        parent::__construct(500, $message, $previous, $headers, $code);
    }
}
