<?php

namespace WeimobCloudBoot\Facade;

/**
 * 微盟云MySQL 静态代理
 * 在标准实现下，实际上所有静态方法会被转发到一个 @see \PDO 类的实例
 * 请参考 * @see \PDO
 */
class DBFacade extends Facade
{
    /**
     * 给静态代理设置服务名称
     * 子类必须覆盖这个方法
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'weimobCloudMysql';
    }
}