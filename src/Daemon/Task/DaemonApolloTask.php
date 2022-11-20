<?php

namespace WeimobCloudBoot\Daemon\Task;

use WeimobCloudBoot\Boot\BaseFramework;
use WeimobCloudBoot\Util\ApolloUtil;

class DaemonApolloTask extends BaseFramework
{
    public function handle(): void
    {
        /** @var ApolloUtil $apollo */
        $apollo = self::getContainer()->get('apolloUtil');
        $apollo->writeToFile();
    }
}