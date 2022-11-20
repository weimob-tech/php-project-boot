<?php

namespace WeimobCloudBootTest\Component\Store;

use Redis;
use WeimobCloudBoot\Component\Store\RedisFactory;
use WeimobCloudBoot\Facade\RedisFacade;
use WeimobCloudBootTest\Base\BaseTestCase;

class RedisTest extends BaseTestCase
{
    public static function setUpBeforeClass() {
        $_SERVER['redis_host'] = 'localhost';
        $_SERVER['redis_port'] = '6379';
        $_SERVER['redis_password'] = 'test1234';
    }

    public function testRedisFactory() {
        /** @var RedisFactory $redisFactory */
        $redisFactory = $this->getApp()->getContainer()->get('redisFactory');

        $redis = $redisFactory->buildBuiltinRedisInstance();
        $this->assertNotNull($redis);

        $redis->set('hello', 'world');

        $this->assertEquals('world', $redis->get('hello'));

        /** @var Redis $weimobCloudRedis */
        $weimobCloudRedis = $this->getApp()->getContainer()->get('weimobCloudRedis');
        $this->assertNotNull($weimobCloudRedis);

        $weimobCloudRedis->set('good', 'job');

        $this->assertEquals('job', $weimobCloudRedis->get('good'));
    }

    public function testRedisFacade()
    {
        RedisFacade::set('weimob', 'cloud');
        $this->assertEquals('cloud', RedisFacade::get('weimob'));
    }
}