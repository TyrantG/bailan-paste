<?php


namespace App\Api\Requests;

use App\Http\FormRequest;

class ContentCreate extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'content' => ['required', 'string'],
            'password' => ['nullable', 'string', 'min:4', 'max:80'],
            'count_limit' => ['nullable', 'integer'],
            'time_limit' => ['nullable', 'integer'],
            'return_type' => ['nullable', 'integer'],
            'auto_password' => ['nullable', 'integer'],
        ];
    }

    public function messages()
    {
        return [
            'content.required' => '请填写内容',
            'string.required' => '文本内容为字符串类型',
            'password.string' => '密码为字符串类型',
            'password.min' => '密码最少为4个字符',
            'password.max' => '密码最多为80个字符',
            'count_limit.integer' => '浏览次数为整数类型',
            'time_limit.integer' => '浏览时间为整数类型',
            'return_type.integer' => '返回类型为整数类型',
            'auto_password.integer' => '密码生成为整数类型',
        ];
    }
}

