<?php

namespace WeimobCloudBoot\Controller;

use JsonMapper;
use ReflectionClass;
use Slim\Http\Request;
use Slim\Http\Response;
use Throwable;
use WeimobCloudBoot\Ability\SpecTypeEnum;
use WeimobCloudBoot\Boot\BaseFramework;
use WeimobCloudBoot\Facade\LogFacade;

/**
 * 新云 spi入口
 */
class XinyunSpiController extends BaseFramework
{
    public function handle(Request $request, Response $response, array $args){
        try {
            $beanName = $args['serviceName'];
            $methodName = SpecTypeEnum::XINYUN_SPI_METHOD_NAME;

            $pidStr = $request->getHeader('saas-pid');
            if (count($pidStr) > 0) {
                $pidStr = $pidStr[0];
            }
            $spiRegistry = $this->getContainer()->get("spiRegistry");

            /** @var \WeimobCloudBoot\Ability\Spi\SpiRegistry $spiRegistry */
            $spiInstance = $spiRegistry->getSpi($beanName, SpecTypeEnum::XINYUN);
            if (empty($spiInstance)) {
                LogFacade::info(sprintf("Cannot find spi service bean!,beanName: %s", $beanName));
                $result = ["code" => ["errcode" => "0404", "errmsg" => "Cannot find spi service bean!"]];
                return $response->withJson(json_encode($result));
            }
            $spiBody = $request->getBody();

            $result = $this->invokeMethod($spiInstance, $methodName, $spiBody, $pidStr);
            return $response->withJson($result);
        }catch (Throwable $ex){
            LogFacade::info(sprintf("服务器内部错误,ex: %s", $ex->getMessage()));
            $result = ["code"=>["errcode"=>"0500","errmsg"=>"Invoke spi service method error！"]];
            return $response->withJson($result);
        }
    }

    private function invokeMethod($spiInstance, $methodName, $spiBody, $pidStr)
    {
        $spiClass = get_class($spiInstance);
        $ref = new ReflectionClass($spiClass);
        $method = $ref->getMethod($methodName);
        $parameters = $method->getParameters();
        $parameterType = $parameters[0]->getType();

        $requestClass = new ReflectionClass($parameterType->getName());
        $getParamsMethod = $requestClass->getMethod("getParams");

        $jsonDecoder = new JsonMapper();
        $tempSpiBody = json_decode($spiBody);
        $tempObj = $jsonDecoder->map($tempSpiBody,$parameterType->getName());

        $params = $jsonDecoder->map(json_decode($tempSpiBody->params),$getParamsMethod->getReturnType()->getName());

        $tempObj->setParams($params);

        if (!empty($pidStr) && is_numeric($pidStr)) {
            $pid = (int)$pidStr;
            $tempObj->setPid($pid);
        }

        return $method->invoke($spiInstance, $tempObj);
    }
}