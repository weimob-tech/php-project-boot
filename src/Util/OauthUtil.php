<?php

namespace WeimobCloudBoot\Util;

use WeimobCloudBoot\Boot\BaseFramework;
use WeimobCloudBoot\Component\Oauth\AccessToken;
use WeimobCloudBoot\Exception\OauthException;

class OauthUtil extends BaseFramework
{
    /**
     * 客户端凭证授权
     * @param string $clientName
     * @param int|null $shopId
     * @param string|null $shopType
     * @return mixed
     * @throws OauthException
     */
    public function getCCToken(string $clientName, int $shopId=null, string $shopType=null)
    {
        $accessToken = $this->initOauth($clientName);
        return $accessToken->getCCToken($shopId, $shopType);
    }

    /**
     * 授权码授权
     * @param string $clientName
     * @param $code
     * @param $redirectUri
     * @return mixed
     * @throws OauthException
     */
    public function getAuthCodeToken(string $clientName,$code, $redirectUri)
    {
        $accessToken = $this->initOauth($clientName);

        return $accessToken->getAuthCodeToken($code, $redirectUri);
    }

    /**
     * 刷新token
     * @param string $clientName
     * @param $refreshToken
     * @param $state
     * @return mixed
     * @throws OauthException
     */
    public function refreshToken(string $clientName, $refreshToken, $state=null)
    {
        $accessToken = $this->initOauth($clientName);

        return $accessToken->refreshToken($refreshToken, $state);
    }

    private function initOauth(string $clientName):AccessToken
    {
        /** @var EnvUtil $envUtil*/
        $envUtil = $this->getContainer()->get('envUtil');
        $baseUrl = $envUtil->get("weimob.cloud.baseUrl");
        if(empty($baseUrl))
        {
            throw new OauthException("请配置授权域名(对应配置项为weimob.cloud.baseUrl)");
        }
        $clientInfo = $envUtil->getClientInfos();
        if(empty($clientInfo[$clientName])
            || empty($clientInfo[$clientName]["clientId"])
            || empty($clientInfo[$clientName]["clientSecret"]))
        {
            throw new OauthException("clientName对应的clientInfo配置信息未配置完整");
        }

        /** @var AccessToken $accessToken */
        $accessToken = $this->getContainer()->get('accessToken');
        $accessToken->setBaseUrl($baseUrl);
        $accessToken->setClientId($clientInfo[$clientName]["clientId"]);
        $accessToken->setClientSecret($clientInfo[$clientName]["clientSecret"]);

        return $accessToken;
    }
}