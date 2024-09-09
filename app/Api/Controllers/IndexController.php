<?php

namespace App\Api\Controllers;

use App\Api\Requests\ContentCreate;
use App\Api\Requests\ContentUpdate;
use App\Http\Controllers\ApiController;
use App\Interfaces\ResponseCode;
use App\Models\Content;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class IndexController extends ApiController implements ResponseCode
{
    public function index($path): JsonResponse
    {
        @list($true_path, $password) = explode('@', $path);

        // 先尝试id查询
        $content = Content::find($true_path, ['id', 'unique_path', 'content', 'password', 'is_destroy', 'count_limit', 'time_limit', 'views', 'created_at']);

        // 再尝试unique_path查询
        if (!$content || $content->unique_path) {
            $content = Content::where('unique_path', $true_path)->first(['id', 'unique_path', 'content', 'password', 'is_destroy', 'count_limit', 'time_limit', 'views', 'created_at']);
        }

        // 地址不存在或已软删除
        if (empty($content)) return $this->errorResponseFull(self::MODEL_NOT_FOUND);

        // 限制
        if (
            $content->is_destroy &&
            (
                ($content->count_limit > 0 && $content->count_limit <= $content->views) ||
                ($content->time_limit > 0 && Carbon::make($content->created_at)->addMinutes($content->time_limit)->lte(Carbon::now()))
            )
        ) {
            $content->delete();
            return $this->errorResponseFull(self::MODEL_NOT_FOUND);
        }

        // 密码
        if ($password != $content->password) return $this->errorResponseFull(self::AUTHENTICATION_FAILED);

        $content->views++;
        $content->save();

        return $this->jsonResponse($content->content);
    }

    public function create(ContentCreate $contentCreate): JsonResponse
    {
        $params = $contentCreate->validated();

        $insert = [];
        $return_type = 0;

        $insert['content'] = $params['content'];
        $insert['ip'] = $contentCreate->ip();
        $insert['is_destroy'] = 0;

        // 处理密码
        if (isset($params['password'])) {
            $insert['password'] = $params['password'];
        } elseif (isset($params['auto_password']) && $params['auto_password'] = 1) {
            $insert['password'] = randomKeys(6);
        } else {
            $insert['password'] = null;
        }

        // 处理限制
        if (isset($params['count_limit'])) {
            $insert['is_destroy'] = 1;
            $insert['count_limit'] = $params['count_limit'];
        }

        if (isset($params['time_limit'])) {
            $insert['is_destroy'] = 1;
            $insert['time_limit'] = $params['time_limit'];
        }

        // 返回
        if (!isset($params['return_type']) || $params['return_type'] == 1) {
            $return_type = 1;
            $insert['unique_path'] = strtolower(randomKeys(16));
        }

        $content = Content::create($insert);

        $return_data['password'] = $content->password ?: '';
        $return_data['path'] = $return_type == 1 ? $content->unique_path : $content->id;
        $hash_text = $return_data['path'] . ($return_data['password'] ? '@' . $return_data['password'] : '');
        $return_data['auth_code'] = Hash::make($hash_text);

        return $this->jsonResponse($return_data);
    }

    public function update(ContentUpdate $contentUpdate): JsonResponse
    {
        $params = $contentUpdate->validated();

        @list($true_path, $password) = explode('@', $params['path']);

        // 先尝试id查询
        $content = Content::find($true_path, ['id', 'unique_path', 'content', 'password', 'is_destroy', 'count_limit', 'time_limit', 'views', 'created_at']);

        // 再尝试unique_path查询
        if (!$content || $content->unique_path) {
            $content = Content::where('unique_path', $true_path)->first(['id', 'unique_path', 'content', 'password', 'is_destroy', 'count_limit', 'time_limit', 'views', 'created_at']);
        }

        // 地址不存在或已软删除
        if (empty($content)) return $this->errorResponseFull(self::MODEL_NOT_FOUND);

        // 限制
        if (
            $content->is_destroy &&
            (
                ($content->count_limit > 0 && $content->count_limit <= $content->views) ||
                ($content->time_limit > 0 && Carbon::make($content->created_at)->addMinutes($content->time_limit)->lte(Carbon::now()))
            )
        ) {
            $content->delete();
            return $this->errorResponseFull(self::MODEL_NOT_FOUND);
        }

        // 密码
        if ($password != $content->password) return $this->errorResponseFull(self::AUTHENTICATION_FAILED);

        try {
            if (!Hash::check($params['path'], $params['auth_code'])) return $this->errorResponseFull(self::AUTHENTICATION_FAILED);
        } catch (\Exception $exception) {
            $message = $exception->getMessage();
            return response()->json([
                'return_code' => self::BAD_REQUEST[0],
                'result_code' => 'FAILED',
                'data' => null,
                'message' => $message === 'This password does not use the Bcrypt algorithm.' ? '授权码格式错误' : $message,
            ]);
        }

        $content->content = $params['content'];

        $return_data['path'] = $content->unique_path;
        $return_data['password'] = $content->password ?: '';
        $return_data['auth_code'] = $params['auth_code'];

        if (isset($params['refresh_password']) && $params['refresh_password'] == 1) {
            $content->password = $return_data['password'] = randomKeys(6);
        }

        if (isset($params['refresh_code']) && $params['refresh_code'] == 1) {
            $hash_text = $return_data['path'] . ($return_data['password'] ? '@' . $return_data['password'] : '');
            $return_data['auth_code'] = Hash::make($hash_text);
        }

        $content->save();
        return $this->jsonResponse($return_data);
    }
}
