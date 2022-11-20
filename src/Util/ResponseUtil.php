<?php

namespace WeimobCloudBoot\Util;

use WeimobCloudBoot\Exception\ApiFailException;

class ResponseUtil
{
    /**
     * 校验api接口是否调用成功
     * @throws ApiFailException
     */
    public static function checkFail(array $array)
    {
        $code = $array["code"];
        if(empty($code) || $code["errcode"] !== '0')
        {
            throw new ApiFailException("api 接口调用失败");
        }
    }
}