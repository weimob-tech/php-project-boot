<?php

namespace WeimobCloudBoot\Facade;

/**
 * OauthUtil 静态代理
 * 在标准实现下，实际上所有静态方法会被转发到一个 @see \WeimobCloudBoot\Util\OauthUtil 类的实例
 * 请参考 * @see \WeimobCloudBoot\Util\OauthUtil
 *
 * @method static getCCToken(string $clientName, int $shopId=null, string $shopType=null);
 * @method static getAuthCodeToken(string $clientName,$code, $redirectUri);
 * @method static refreshToken(string $clientName, $refreshToken, $state=null);
 */
class OauthUtilFacade extends Facade
{

    protected static function getFacadeAccessor(): string
    {
        return "oauthUtil";
    }
}