<?php


namespace App\Interfaces;

interface ResponseCode
{
    const RESPONSE_SUCCESS                                  = [0,       '请求成功'];
    const BAD_REQUEST                                       = [4000,    '参数错误'];
    const AUTHENTICATION_FAILED                             = [4001,    '鉴权失败'];
    const MODEL_NOT_FOUND                                   = [4004,    '数据未找到'];
    const T00_MANY_REQUESTS                                 = [4029,    '请求次数过多'];
    const SERVER_ERROR                                      = [5000,    '服务器错误'];


}
