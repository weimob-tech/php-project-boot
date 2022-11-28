<?php

namespace WeimobCloudBoot\Facade;

/**
 * WeimobHttpUtil 静态代理
 * 在标准实现下，实际上所有静态方法会被转发到一个 @see \WeimobCloudBoot\Util\WeimobHttpUtil 类的实例
 * 请参考 * @see \WeimobCloudBoot\Util\WeimobHttpUtil
 *
 * @method static string invokeApi(string $relativePath, string $accessToken, $requestBody);
 */
class WeimobHttpUtilFacade extends Facade
{

    protected static function getFacadeAccessor(): string
    {
        return "weimobHttpUtil";
    }
}