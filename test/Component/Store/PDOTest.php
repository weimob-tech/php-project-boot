<?php

namespace WeimobCloudBootTest\Component\Store;

use PDO;
use WeimobCloudBoot\Component\Store\PDOFactory;
use WeimobCloudBoot\Facade\LogFacade;
use WeimobCloudBootTest\Base\BaseTestCase;

class PDOTest extends BaseTestCase
{
    public static function setUpBeforeClass() {
        $_SERVER['mysql_host'] = '127.0.0.1';
        $_SERVER['mysql_port'] = "3306";
        $_SERVER['mysql_username'] = 'root';
        $_SERVER['mysql_password'] = 'test1234';
        $_SERVER['mysql_dbname'] = 'test_weimobcloud_db';

        $_SERVER['APP_ID'] = 'test_app_id';

        define('WMCLOUD_BOOT_APP_DIR', realpath(__DIR__ . '/../../'));
    }

    public function test()
    {
        /** @var PDOFactory $pdoFactory */
        $pdoFactory = $this->getApp()->getContainer()->get('pdoFactory');

        $pdo = $pdoFactory->buildBuiltinMySQLInstance();
        $this->assertNotNull($pdo);

        // create table test_table(id int not null primary key,`name` varchar(100) not null);
        // insert into test_table(id,name) values(1,'hello'),(2,"world");
        $res = $pdo->query('select id, `name` from `test_table`;');
        while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
            LogFacade::info(json_encode($row));
        }

    }
}