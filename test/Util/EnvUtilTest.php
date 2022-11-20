<?php

namespace WeimobCloudBootTest\Util;

use WeimobCloudBoot\Util\EnvUtil;
use WeimobCloudBootTest\Base\BaseTestCase;

class EnvUtilTest extends BaseTestCase
{
    public function testGetClientInfos()
    {
        define('WMCLOUD_BOOT_APP_DIR', realpath(__DIR__ . '/../'));
        /** @var EnvUtil $envUtil */
        $envUtil = $this->getApp()->getContainer()->get('envUtil');
        $clientInfo = $envUtil->getClientInfos();

        $this->assertSame("3434343", $clientInfo['a']['clientId']);
        $this->assertSame("9999", $clientInfo['a']['clientSecret']);
    }

    public function testGetFromConfigCenter()
    {
        define('WMCLOUD_BOOT_APP_DIR', realpath(__DIR__ . '/../'));
        /** @var EnvUtil $envUtil */
        $envUtil = $this->getApp()->getContainer()->get('envUtil');
        $clientId = $envUtil->get("weimob.cloud.a.clientId");
        $clientSecret = $envUtil->get("weimob.cloud.a.clientSecret");
        $this->assertSame("3434343", $clientId);
        $this->assertSame("9999", $clientSecret);
    }
}