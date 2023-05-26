<?php

use Psr\Container\ContainerInterface;
use \Slim\App;
use WeimobCloudBoot\Ability\AbilityRegistryWrapper;
use WeimobCloudBoot\Facade\LogFacade;

function initEnv()
{
    // 推定的工程目录
    $assumedAppDir = realpath(__DIR__ . '/../../../..');

    // 检查是在项目运行还是独立运行(例如测试)，判断依据是 composer.json 和 env.php
    if (file_exists($assumedAppDir . '/composer.json') and file_exists($assumedAppDir . '/config/env.php')) {
        require_once($assumedAppDir . '/config/env.php');
    }

    // 如果是项目运行，加载项目目录下 vendor 的 autoload, 否则在自身目录下面寻找 vendor 下的 autoload
    if (defined('WMCLOUD_BOOT_APP_DIR')) {
        require_once(WMCLOUD_BOOT_APP_DIR . '/vendor/autoload.php');
    } else {
        require_once(__DIR__ . '/../vendor/autoload.php');
    }
}

//初始容器
function initContailner():ContainerInterface
{
    return WeimobCloudBoot\Boot\Bootstrap::setupContainer();
}

//初始应用
function initApp(ContainerInterface $container):App
{
    // 初始化应用
    $app = new App($container);
    WeimobCloudBoot\Boot\Bootstrap::setupApp($app);
    WeimobCloudBoot\Facade\Facade::setFacadeApplication($app);
    return $app;
}

//初始框架
function initFrameConfig(App $app)
{
    if (defined('WMCLOUD_BOOT_APP_DIR')) {
        (function () use ($app) {
            require(WMCLOUD_BOOT_APP_DIR . '/config/routes.php');
        })();

        (function () use ($app) {
            if (file_exists(WMCLOUD_BOOT_APP_DIR . '/config/middlewares.php')) {
                require(WMCLOUD_BOOT_APP_DIR . '/config/middlewares.php');
            }
        })();
    }
}

//能力注册发现
function initAbility(ContainerInterface $container): AbilityRegistryWrapper{
    if (defined('WMCLOUD_BOOT_APP_DIR')) {
        $spiRegistry = $container->get("spiRegistry");
        (function () use ($spiRegistry) {
            require(WMCLOUD_BOOT_APP_DIR . '/config/spiRegistry.php');
        })();

        $msgSubscription = $container->get("msgSubscription");
        (function () use ($msgSubscription) {
            require(WMCLOUD_BOOT_APP_DIR . '/config/msgSubscription.php');
        })();

        $wrapper = new AbilityRegistryWrapper();
        $wrapper->spiRegistry = $spiRegistry;
        $wrapper->msgSubscription = $msgSubscription;

        return $wrapper;
    }

    return new AbilityRegistryWrapper();
}

//运行
function running(App $app, AbilityRegistryWrapper $wrapper){
    try {
        if ((isset($wrapper->spiRegistry) and !$wrapper->spiRegistry instanceof \WeimobCloudBoot\Ability\Spi\SpiRegistry)
            or (isset($wrapper->msgSubscription) and !$wrapper->msgSubscription instanceof \WeimobCloudBoot\Ability\Msg\MsgSubscription)
            or (!$app instanceof \Slim\App)) {
            //在 app 端有可能被修改实例，抛异常
            throw new Exception();
        }

        $app->run();
    } catch (Exception $e) {
        // do something
    }
}

function getAndSetRegistered():bool
{
    $shm_key = ftok(__FILE__, 't');
    $shm_id = shmop_open($shm_key, 'c', 0644, 32);
    //读取并写入数据
    $data = shmop_read($shm_id, 0, 32);
    $data = trim($data);
    if(!empty($data)){
        return true;
    }
    shmop_write($shm_id, "true", 0);
    //关闭内存块，并不会删除共享内存，只是清除 PHP 的资源
    shmop_close($shm_id);
    return false;
}

function fixInnerServerBug()
{
    if (isset($_SERVER['SERVER_SOFTWARE']) and preg_match('/^PHP.+Development Server$/', $_SERVER['SERVER_SOFTWARE'])) {
        // 如果确实存在文件，返回文件
        if (file_exists($_SERVER['SCRIPT_NAME'])) {
            return false;
        }
        // 否则则将错误的 PHP_SELF 和 SCRIPT_NAME 重写为 index.php
        $_SERVER['PHP_SELF'] = '/index.php';
        $_SERVER['SCRIPT_NAME'] = '/index.php';
    }
}