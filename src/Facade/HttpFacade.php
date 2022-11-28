<?php


namespace WeimobCloudBoot\Facade;

/**
 * HttpUtil 静态代理
 * 在标准实现下，实际上所有静态方法会被转发到一个 @see \WeimobCloudBoot\Util\HttpUtil 类的实例
 * 请参考 * @see \WeimobCloudBoot\Util\HttpUtil
 *
 * @method static string post($url, $params = [], $headers = []);
 * @method static string get($url, $params = [], $headers = []);
 */
class HttpFacade extends Facade
{

    /**
     * 给静态代理设置服务名称
     * 子类必须覆盖这个方法
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'httpClient';
    }
}