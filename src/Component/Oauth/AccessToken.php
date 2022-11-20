<?php

namespace WeimobCloudBoot\Component\Oauth;

class AccessToken extends AbstractToken
{

    /**
     * 通过 客户端凭证（client credentials）：适用于面向自研商家的 自有型 应用 获取 Access Token
     * 
     * @param string $shopId 
     * @param string $shopType
     * @return mixed
     * 
     */
    public function getCCToken($shopId=null,$shopType=null)
    {
        $requestBody = [
            'grant_type' => 'client_credentials',
        ];
        if (isset($shopId))
        {
            $requestBody['shop_id'] = $shopId;
        }
        if (isset($shopId)){
            $requestBody['shop_type'] = $shopType;
        }
        return self::request($requestBody);
    }
    /**
     * 通过 授权码（authorization code）：适用于面向设计服务商的 工具型 应用 获取 Access Token
     * 
     * @param string $code required
     * @param string $redirectUri required
     */
    public function getAuthCodeToken($code,$redirectUri)
    {
        $requestBody = [
            'grant_type' => 'authorization_code',
            'code' => $code,
            'redirect_uri' => $redirectUri,
        ];
        return self::request($requestBody);
    }

    /**
     * 刷新Token(通过refreshToken刷新Token)
     *
     * @param string $refreshToken required
     * @param string $state
     * @return mixed
     * 根据 接口获取 url
     */
    public function refreshToken($refreshToken,$state=null)
    {
        $requestBody = [
            'grant_type' => 'refresh_token',
            'refresh_token' => $refreshToken,
        ];
        if(isset($state))
        {
            $requestBody['state'] = $state;
        }
        return self::request($requestBody);
    }

    /**
     * 通过 客户端凭证或授权码获取 accessToken
     *
     * @param string $grantType required
     * @param string $shopId
     * @param string $shopType
     * @param string $code
     * @param string $redirectUri
     * @return mixed
     */
    public function getAccessToken(
        $grantType,
        $shopId=null,
        $shopType=null,
        $code=null,
        $redirectUri=null,
        $refreshToken=null,
        $state=null)
    {
        $requestBody = [
            'grant_type' => $grantType,
        ];
        switch ($grantType) {
            // 适用于面向自研商家的 自有型
            case 'client_credentials':
                if (isset($shopId))
                {
                    $requestBody['shop_id'] = $shopId;
                }
                if (isset($shopId)){
                    $requestBody['shop_type'] = $shopType;
                }
                break;
            // 适用于面向设计服务商的 工具型
            case 'authorization_code':
                $requestBody['code'] = $code;
                $requestBody['redirect_uri'] = $redirectUri;
                break;
            // 刷新 token
            case 'refresh_token':
                $requestBody['refresh_token'] = $refreshToken;
                if(isset($state))
                {
                    $requestBody['state'] = $state;
                }
                break;
            default:
                break;
        }
        return self::request($requestBody);
    }

}