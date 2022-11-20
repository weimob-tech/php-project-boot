<?php

namespace WeimobCloudBoot\Component\Store;

use Redis;
use WeimobCloudBoot\Boot\BaseFramework;

class RedisFactory extends BaseFramework
{
    public function buildRedisInstance($host, $port, $password): Redis
    {
        $redis = new Redis();
        $redis->connect($host, $port);
        if (!empty($password)) {
            $redis->auth($password);
        }
        return $redis;
    }

    public function buildBuiltinRedisInstance(): ?Redis
    {
        $host = $this->getEnvUtil()->get('redis.host');
        $port = $this->getEnvUtil()->get('redis.port');
        $password = $this->getEnvUtil()->get('redis.password');

        if (empty($host)) {
            return null;
        }

        return $this->buildRedisInstance($host, $port, $password);
    }
}