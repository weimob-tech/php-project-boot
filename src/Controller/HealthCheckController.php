<?php

namespace WeimobCloudBoot\Controller;

use WeimobCloudBoot\Boot\BaseFramework;
use Slim\Http\Request;
use Slim\Http\Response;

class HealthCheckController extends BaseFramework
{
    public function handle(Request $request, Response $response, array $args)
    {
        return 'success';
    }
}