<?php

use App\Http\Middleware\AcceptJsonHeader;
use App\Interfaces\ResponseCode;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->append(AcceptJsonHeader::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (Throwable $exception, Request $request) {
            if ($exception instanceof ModelNotFoundException) {
                return response()->json([
                    'return_code' => ResponseCode::MODEL_NOT_FOUND[0],
                    'result_code' => 'FAILED',
                    'data' => null,
                    'message' => ResponseCode::MODEL_NOT_FOUND[1],
                ]);
            } elseif ($exception instanceof ValidationException) {
                return response()->json([
                    'return_code' => ResponseCode::BAD_REQUEST[0],
                    'result_code' => 'FAILED',
                    'data' => null,
                    'message' => $exception->errorBag,
                ]);
            } elseif ($exception instanceof AuthenticationException) {
                return $request->expectsJson()
                    ? response()->json([
                        'return_code' => ResponseCode::AUTHENTICATION_FAILED[0],
                        'result_code' => 'FAILED',
                        'data' => null,
                        'message' => ResponseCode::AUTHENTICATION_FAILED[1],
                    ])
                    : redirect()->guest($exception->redirectTo($request) ?? route('login'));
            }
            throw $exception;
        });
    })->create();
