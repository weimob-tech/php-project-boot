<?php

namespace WeimobCloudBootTest\Base;

use PHPUnit\Framework\TestCase;
use Slim\App;
use WeimobCloudBoot\Boot\Bootstrap;
use WeimobCloudBoot\Facade\Facade;

require_once(__DIR__ . '/../../vendor/autoload.php');

abstract class BaseTestCase extends TestCase
{
    protected $app;

    public function getApp(): App
    {
        return $this->app;
    }

    public function setUp()
    {
        $container = Bootstrap::setupContainer();

        $app = new App($container);

        Bootstrap::setupApp($app);

        Facade::setFacadeApplication($app);

        $this->app = $app;
    }
}