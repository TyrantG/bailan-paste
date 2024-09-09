<?php

namespace App\Api\Requests;

use App\Http\FormRequest;

class ContentUpdate extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'content' => ['required', 'string'],
            'path' => ['required', 'string'],
            'auth_code' => ['required', 'string'],
            'refresh_code' => ['nullable', 'numeric', 'max:1'],
            'refresh_password' => ['nullable', 'numeric', 'max:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'content.required' => '请填写内容',
            'content.string' => '文本内容为字符串类型',
            'path.required' => '请填写地址',
            'path.string' => '地址为字符串类型',
            'auth_code.required' => '请填写授权码',
            'auth_code.string' => '授权码为字符串类型',
            'refresh_code.numeric' => '授权码刷新字段为数字',
            'refresh_code.max' => '授权码刷新字段超出最大值',
            'refresh_password.numeric' => '密码刷新字段为数字',
            'refresh_password.max' => '密码刷新字段超出最大值',
        ];
    }
}

