<?php

namespace WeimobCloudBootTest\Ability\Spi;

use WeimobCloudBoot\Ability\SpecTypeEnum;
use WeimobCloudBoot\Ability\Spi\DemoSpiImpl;
use WeimobCloudBoot\Ability\Spi\DemoXinyunSpiImpl;
use WeimobCloudBoot\Ability\Spi\SpiRegistry;
use WeimobCloudBootTest\Base\BaseTestCase;

class SpiRegistryTest extends BaseTestCase
{
    public function testRegister()
    {
        /** @var SpiRegistry $spiRegistry */
        $spiRegistry = $this->getApp()->getContainer()->get('spiRegistry');
        $spiRegistry->register("demoSpiImpl",DemoSpiImpl::class,SpecTypeEnum::WOS);
        $spiRegistry->register("demoSpiImpl",DemoSpiImpl::class);
        $spiRegistry->register("demoSpiImpl",DemoXinyunSpiImpl::class,SpecTypeEnum::XINYUN);
        $this->assertTrue(true);
    }

    public function testGetSpi()
    {
        define('WMCLOUD_BOOT_APP_DIR', 'D:\\phpproject\\php-project-boot2\\test\\');
        /** @var SpiRegistry $spiRegistry */
        $spiRegistry = $this->getApp()->getContainer()->get('spiRegistry');
        $envUtil = $this->getApp()->getContainer()->get('envUtil');
        $clientInfo = $envUtil->getClientInfos();
        $spiRegistry->register("demoSpiImpl",DemoSpiImpl::class,SpecTypeEnum::WOS);
        $spiInstance = $spiRegistry->getSpi("demoSpiImpl");
        $this->assertTrue(true);
    }
}