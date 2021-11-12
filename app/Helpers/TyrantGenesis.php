<?php

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Ramsey\Uuid\Uuid;

if (! function_exists('uuid')) {
    /**
     * 生成 uuid v4
     * @return string
     * */
    function uuid() {
        return Uuid::uuid4()->toString();
    }
}

if (! function_exists('is_url')) {
    /**
     * 判断字符串是否是 url
     * @param string $url
     * @return boolean
     * */
    function is_url($url){
        $preg = "/http[s]?:\/\/[\w.]+[\w\/]*[\w.]*\??[\w=&\+\%]*/is";
        return preg_match($preg, $url);
    }
}

if (! function_exists('get_web_image')) {
    /**
     * 下载网络图片
     * @param string $url
     * @return boolean|string
     * */
    function get_web_image($url) {
        try {
            $client = new Client(['verify' => false]);
            return $client->request('get', $url)->getBody()->getContents();
        } catch (GuzzleException $e) {
            Log::error('获取网络图片失败', $e);
            return false;
        }
    }
}

if (! function_exists('array_group_by')){
    /**
     * 数组分组 感觉比 collect()->groupBy() 快一点
     * @param array $arr
     * @param string $key
     * @return array
     *
     */
    function array_group_by($arr, $key)
    {
        $grouped = [];
        foreach ($arr as $value) {
            $grouped[$value[$key]][] = $value;
        }
        if (func_num_args() > 2) {
            $args = func_get_args();
            foreach ($grouped as $key => $value) {
                $params = array_merge([$value], array_slice($args, 2, func_num_args()));
                $grouped[$key] = call_user_func_array('array_group_by', $params);
            }
        }
        return $grouped;
    }
}

if (! function_exists('randomKeys')) {
    /**
     * 生成随机字符串
     * @param string $length
     * @return string
     * */
    function randomKeys($length)
    {
        $key = '';
        $pattern = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLOMNOPQRSTUVWXYZ';
        for($i = 0; $i < $length; $i++) {
            $key .= $pattern[mt_rand(0, 61)];
        }
        return $key;
    }
}
