<?php

namespace WeimobCloudBoot\Facade;

/**
 * DataSecurityUtil 静态代理
 * 默认实现 @see \WeimobCloudBoot\Util\DataSecurityUtil
 *
 * @method static null|bool isEncrypt(string $accessToken, string $source)
 * @method static null|string decrypt(string $accessToken, string $source)
 * @method static null|string encrypt(string $accessToken, string $source)
 */
class DataSecurityUtilFacade extends Facade
{

    protected static function getFacadeAccessor(): string
    {
        return "dataSecurityUtil";
    }
}