<?php

namespace App\Http\Controllers;

use App\Interfaces\ResponseCode;
use Illuminate\Http\JsonResponse;

class ApiController extends Controller implements ResponseCode
{
    /**
     * 返回成功响应
     * @param mixed $data
     * @param string $message
     *
     * @return JsonResponse
     * */
    public function jsonResponse($data = [], $message = self::RESPONSE_SUCCESS[1] ?? '请求成功')
    {
        return response()->json([
            'return_code' => self::RESPONSE_SUCCESS[0],
            'result_code' => 'SUCCESS',
            'data' => $data,
            'message' => $message,
        ]);
    }

    /**
     * 返回自定义业务阻断响应
     * @param integer $code
     * @param string $message
     *
     * @return JsonResponse
     * */
    public function errorResponse($code = self::SERVER_ERROR[0] ?? 5000, $message = self::SERVER_ERROR[1] ?? '请求异常')
    {
        return response()->json([
            'return_code' => $code,
            'result_code' => 'FAILED',
            'data' => null,
            'message' => $message,
        ]);
    }

    /**
     * 返回完全型业务阻断响应
     * @param array $error
     *
     * @return JsonResponse
     * */
    public function errorResponseFull($error = self::SERVER_ERROR)
    {
        return response()->json([
            'return_code' => $error[0],
            'result_code' => 'FAILED',
            'data' => null,
            'message' => $error[1],
        ]);
    }

    /**
     * 返回异常响应
     * @param \Exception $e
     * @param integer $code
     *
     * @return JsonResponse
     * */
    public function abortResponse(\Exception $e, $code = self::SERVER_ERROR[0] ?? 500)
    {
        return response()->json([
            'return_code' => $code,
            'result_code' => 'FAILED',
            'line' => $e->getLine(),
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'trace' => $e->getTrace(),
        ]);
    }
}
