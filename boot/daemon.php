<?php

use Psr\Container\ContainerInterface;
use WeimobCloudBoot\Boot\Bootstrap;
use WeimobCloudBoot\Daemon\Registry\IntervalTimerRegistry;
use WeimobCloudBoot\Daemon\Worker\IntervalTimerWorker;
use WeimobCloudBoot\Facade\Facade;

require_once(__DIR__ . '/../boot/functions.php');

init();

// init
$container = (function (): ContainerInterface {

    // set slim app
    $container = Bootstrap::setupContainer();
    $container['intervalTimerRegistry'] = function (ContainerInterface $container) {
        return new IntervalTimerRegistry($container);
    };

    Facade::setFacadeApplication(new \Slim\App($container));
    return $container;
})();

// timing task workers
$intervalTimerWorker = new \Workerman\Worker();
$intervalTimerWorker->count = 1;

$intervalTimerWorker->onWorkerStart = function ($intervalTimerWorker) use ($container) {
    (new IntervalTimerWorker($container))->onWorkerStart($intervalTimerWorker);
};

// start
\Workerman\Worker::runAll();
