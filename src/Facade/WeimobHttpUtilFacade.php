<?php

namespace WeimobCloudBoot\Facade;

class WeimobHttpUtilFacade extends Facade
{

    protected static function getFacadeAccessor(): string
    {
        return "weimobHttpUtil";
    }
}