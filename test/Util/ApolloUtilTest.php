<?php

namespace WeimobCloudBootTest\Util;

use WeimobCloudBoot\Util\ApolloUtil;
use WeimobCloudBoot\Util\EnvUtil;
use WeimobCloudBootTest\Base\BaseTestCase;

class ApolloUtilTest extends BaseTestCase
{
    public static function setUpBeforeClass() {
        $_SERVER['APP_ID'] = 'public.arch-furion';
        $_SERVER['apollo.meta'] = "http://apollo.qa.internal.weimobqa.com";
        $_SERVER['weimob_cloud_appSecret'] = 'test';
    }

    public function test() {
        /** @var ApolloUtil $apolloUtil */
        $apolloUtil = $this->getApp()->getContainer()->get('apolloUtil');
        $apolloUtil->writeToFile();

        /** @var EnvUtil $env */
        $env = $this->getApp()->getContainer()->get('envUtil');

        $this->assertEquals('https://oms.hsmob.com/cas/login/', $env->get("cas.login.url"));
        $this->assertEquals('https://oms.hsmob.com/cas/serviceValidate/', $env->get("cas.validate.url"));
    }
}