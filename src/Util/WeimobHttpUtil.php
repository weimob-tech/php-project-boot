<?php

namespace WeimobCloudBoot\Util;

use WeimobCloudBoot\Boot\BaseFramework;
use WeimobCloudBoot\Component\Http\HttpClientWrapper;
use WeimobCloudBoot\Exception\ApiFailException;

/**
 * 微盟api接口调用工具类
 */
class WeimobHttpUtil extends BaseFramework
{
    /**
     * 调用weimob api接口
     * @param string $relativePath http接口地址（不包含域名）
     * @param String $accessToken accessToken
     * @param $requestBody 请求对象体
     * @return string
     */
    public function invokeApi(string $relativePath, string $accessToken, $requestBody):string
    {
        /** @var EnvUtil $envUtil*/
        $envUtil = $this->getContainer()->get('envUtil');
        $baseUrl = $envUtil->get("weimob.cloud.baseUrl");

        if(empty($baseUrl))
        {
            throw new ApiFailException("请配置授权域名(对应配置项为weimob.cloud.baseUrl)");
        }

        if(empty($accessToken))
        {
            throw new ApiFailException("accessToken不能为空");
        }

        /** @var HttpClientWrapper $client */
        $client = $this->getContainer()->get('httpClient');

        $apiPath = sprintf("%s/%s?accesstoken=%s", $baseUrl, $relativePath, $accessToken);
        $r = $client->post($apiPath, null, json_encode($requestBody));

        return $r->getBody();
    }
}