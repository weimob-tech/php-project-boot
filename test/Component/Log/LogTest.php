<?php

namespace WeimobCloudBootTest\Component\Log;

use WeimobCloudBoot\Facade\LogFacade;
use WeimobCloudBootTest\Base\BaseTestCase;

class LogTest extends BaseTestCase
{
    public static function setUpBeforeClass()
    {
        $_SERVER['APP_ID'] = 'weimob.cloud-test-app';
    }

    public function test()
    {
        $this->assertTrue(LogFacade::info("hello, world"));
        $this->assertTrue(LogFacade::warn("hello, world"));
        $this->assertTrue(LogFacade::error("hello, world"));
    }
}