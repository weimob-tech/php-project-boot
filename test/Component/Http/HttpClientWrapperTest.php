<?php

namespace WeimobCloudBootTest\Component\Http;

use WeimobCloudBoot\Component\Http\HttpClientWrapper;
use WeimobCloudBootTest\Base\BaseTestCase;

class HttpClientWrapperTest extends BaseTestCase
{
    public function testGet()
    {
        /** @var HttpClientWrapper $client */
        $client = $this->getApp()->getContainer()->get('httpClient');

        $r = $client->get('https://www.baidu.com');

        $this->assertRegExp('/百度/', $r->getBody());
    }

    public function testPost()
    {
        /** @var HttpClientWrapper $client */
        $client = $this->getApp()->getContainer()->get('httpClient');

        $r = $client->post('https://test.internal.weimobdev.com/testPath', ['X-Access-Code: 1234'], json_encode(['projectId' => 'titan']));

        $response = $r->getBodyAsJson();

        $this->assertSame(200, $r->getCode());
        $this->assertSame("0", $response['code']['errcode']);
    }

}