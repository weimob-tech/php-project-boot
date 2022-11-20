<?php

namespace WeimobCloudBoot\Facade;

class OauthUtilFacade extends Facade
{

    protected static function getFacadeAccessor(): string
    {
        return "oauthUtil";
    }
}