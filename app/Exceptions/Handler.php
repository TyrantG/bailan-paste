<?php

namespace App\Exceptions;

use App\Interfaces\ResponseCode;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler implements ResponseCode
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var string[]
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var string[]
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof ModelNotFoundException) {
            return response()->json([
                'return_code' => self::MODEL_NOT_FOUND[0],
                'result_code' => 'FAILED',
                'data' => null,
                'message' => self::MODEL_NOT_FOUND[1],
            ]);
        } elseif ($exception instanceof ValidationException) {
            return response()->json([
                'return_code' => self::BAD_REQUEST[0],
                'result_code' => 'FAILED',
                'data' => null,
                'message' => $exception->errorBag,
            ]);
        } elseif ($exception instanceof AuthenticationException) {
            return $request->expectsJson()
                ? response()->json([
                    'return_code' => self::AUTHENTICATION_FAILED[0],
                    'result_code' => 'FAILED',
                    'data' => null,
                    'message' => self::AUTHENTICATION_FAILED[1],
                ])
                : redirect()->guest($exception->redirectTo() ?? route('login'));
        } elseif ($exception instanceof ThrottleRequestsException) {
            return $request->expectsJson()
                ? response()->json([
                    'return_code' => self::T00_MANY_REQUESTS[0],
                    'result_code' => 'FAILED',
                    'data' => null,
                    'message' => self::T00_MANY_REQUESTS[1],
                ])
                : redirect()->guest($exception->redirectTo() ?? route('login'));
        }
        return parent::render($request, $exception);
    }
}
