<?php

namespace WeimobCloudBoot\Daemon\Registry;

use Psr\Container\ContainerInterface;
use WeimobCloudBoot\Boot\BaseFramework;
use WeimobCloudBoot\Daemon\Task\DaemonApolloTask;

class IntervalTimerRegistry extends BaseFramework
{
    private $beanPool = [];


    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);

        $this->initTask();
    }


    public function getBeanPool(): array
    {
        return $this->beanPool;
    }


    /**
     * register
     * @param string $name
     * @param callable $callback
     * @param float $timeInterval
     * @param array $args
     * @param bool $persistent
     */
    private function register(string $name, callable $callback, float $timeInterval, array $args = [], bool $persistent = true): void
    {
        $this->beanPool[$name] = ['callback' => $callback, 'timeInterval' => $timeInterval, 'args' => $args, 'persistent' => $persistent];
    }


    private function initTask()
    {
        $this->register(
            'weimob_cloud_boot_apollo_once',
            [new DaemonApolloTask($this->getContainer()), 'handle'],
            0.1,
            [],
            false
        );

        $this->register(
            'weimob_cloud_boot_apollo_loop',
            [new DaemonApolloTask($this->getContainer()), 'handle'],
            30
        );
    }
}