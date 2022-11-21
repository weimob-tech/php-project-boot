<?php

namespace WeimobCloudBoot\Util;

use WeimobCloudBoot\Boot\BaseFramework;
use WeimobCloudBoot\Component\Encryption\DataSecurity;
use WeimobCloudBoot\Exception\ApiFailException;
use WeimobCloudBoot\Exception\OauthException;

class DataSecurityUtil extends BaseFramework
{
    /**
     * 数据是否加密 用于判断指定数据是否已加密
     * @param string $accessToken
     * @param string $source
     * @return bool|null
     * @throws OauthException
     * @throws ApiFailException
     */
    public function isEncrypt(string $accessToken, string $source):?bool
    {
        $dataDES = $this->initDataSecurity($accessToken);

        $res =  $dataDES->isEncrypt($source);

        ResponseUtil::checkFail($res);

        return $res["data"]["isEncrypt"];
    }

    /**
     * 数据加密 用于单项数据加密。
     * @param string $accessToken
     * @param string $source
     * @return string|null
     * @throws ApiFailException
     * @throws OauthException
     */
    public function decrypt(string $accessToken, string $source):?string
    {
        $dataDES = $this->initDataSecurity($accessToken);

        $res =  $dataDES->encrypt($source);

        ResponseUtil::checkFail($res);

        return $res["data"]["result"];
    }

    /**
     * 数据解密 用于单项数据解密
     * @param string $accessToken
     * @param string $source
     * @return string|null
     * @throws ApiFailException
     * @throws OauthException
     */
    public function encrypt(string $accessToken, string $source):?string
    {
        $dataDES = $this->initDataSecurity($accessToken);

        $res =  $dataDES->decrypt($source);

        ResponseUtil::checkFail($res);

        return $res["data"]["result"];
    }

    /**
     * @param string $accessToken
     * @return DataSecurity
     * @throws OauthException
     */
    private function initDataSecurity(string $accessToken)
    {
        /** @var EnvUtil $envUtil*/
        $envUtil = $this->getContainer()->get('envUtil');
        $baseUrl = $envUtil->get("weimob.cloud.baseUrl");
        if(empty($baseUrl))
        {
            throw new OauthException("请配置授权域名(对应配置项为weimob.cloud.baseUrl)");
        }

        if(empty($accessToken))
        {
            throw new OauthException("accessToken不能为空");
        }

        /** @var DataSecurity $dataDES */
        $dataDES = $this->getContainer()->get('dataDES');
        $dataDES->setBaseUrl($baseUrl);
        $dataDES->setAccessToken($accessToken);

        return $dataDES;
    }
}