<?php

namespace WeimobCloudBoot\Facade;

/**
 * EnvUtil 静态代理
 * 在标准实现下，实际上所有静态方法会被转发到一个 @see \WeimobCloudBoot\Util\EnvUtil 类的实例
 * 请参考 * @see \WeimobCloudBoot\Util\EnvUtil
 *
 * @method static string get(String $key);
 * @method static string getAppName();
 * @method static string getPostUrl();
 * @method static string getApolloMetaServer();
 * @method static string getAppId();
 * @method static string getWeimobCloudAppId();
 * @method static string getAppSecret();
 * @method static string getEnv();
 * @method static int getLogLevel();
 * @method static array getClientInfos();
 */
class EnvUtilFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'envUtil';
    }
}