<?php

namespace WeimobCloudBootTest\Ability\Spi;

use WeimobCloudBoot\Ability\Msg\DemoMsgImpl;
use WeimobCloudBoot\Ability\Msg\MsgInfo;
use WeimobCloudBoot\Ability\Msg\MsgSubscription;
use WeimobCloudBoot\Ability\SpecTypeEnum;
use WeimobCloudBoot\Ability\Spi\DemoSpiImpl;
use WeimobCloudBoot\Ability\Spi\SpiRegistry;
use WeimobCloudBootTest\Base\BaseTestCase;

class MsgSubsriptionTest extends BaseTestCase
{
    public function testSubscribe()
    {
        define('WMCLOUD_BOOT_APP_DIR', 'D:\\phpproject\\php-project-boot2\\test\\');
        /** @var MsgSubscription $msgSubscription */
        $msgSubscription = $this->getApp()->getContainer()->get('msgSubscription');
        $msgSubscription->subscribe(new MsgInfo("bos.employee.status","update"),DemoMsgImpl::class,SpecTypeEnum::WOS);
        $msgSubscription->subscribe(new MsgInfo("bos.employee.status","update"),DemoMsgImpl::class);
        //$msgSubscription->subscribe("demoMsgImpl",DemoMsgImpl::class,SpecTypeEnum::XINYUN);
        $this->assertTrue(true);
    }

    public function testGetMsg()
    {
        define('WMCLOUD_BOOT_APP_DIR', 'D:\\phpproject\\php-project-boot2\\test\\');
        /** @var MsgSubscription $msgSubscription */
        $msgSubscription = $this->getApp()->getContainer()->get('msgSubscription');
        $envUtil = $this->getApp()->getContainer()->get('envUtil');
        $clientInfo = $envUtil->getClientInfos();
        $msgSubscription->subscribe(new MsgInfo("bos.employee.status","update"),DemoMsgImpl::class,SpecTypeEnum::WOS);
        $spiInstance = $msgSubscription->getMsg(new MsgInfo("bos.employee.status","update"));
        $this->assertTrue(true);
    }
}