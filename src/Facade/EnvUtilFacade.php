<?php

namespace WeimobCloudBoot\Facade;

class EnvUtilFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'envUtil';
    }
}