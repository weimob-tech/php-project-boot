<?php

namespace WeimobCloudBoot\Controller;

use JsonMapper;
use ReflectionClass;
use Slim\Http\Request;
use Slim\Http\Response;
use Throwable;
use WeimobCloudBoot\Ability\Msg\MsgInfo;
use WeimobCloudBoot\Ability\Msg\MsgSubscription;
use WeimobCloudBoot\Ability\Msg\WosOpenMessage;
use WeimobCloudBoot\Ability\SpecTypeEnum;
use WeimobCloudBoot\Boot\BaseFramework;
use WeimobCloudBoot\Facade\LogFacade;


class WosMsgController extends BaseFramework
{
    public function handle(Request $request, Response $response, array $args){
        try {
            $msgBody = $request->getBody();

            $jsonDecoder = new JsonMapper();
            /** @var WosOpenMessage $wosOpenMessage */
            $wosOpenMessage = $jsonDecoder->map(json_decode($msgBody), new WosOpenMessage());
            $msgInfo = new MsgInfo($wosOpenMessage->getTopic(), $wosOpenMessage->getEvent());

            $specType = $wosOpenMessage->getSpecsType();
            if (empty($specType)) {
                $specType = SpecTypeEnum::WOS;
            }

            $msgSubscription = $this->getContainer()->get("msgSubscription");

            /** @var MsgSubscription $msgSubscription */
            $msgInstance = $msgSubscription->getMsg($msgInfo, $specType);
            if(empty($msgInstance))
            {
                LogFacade::info(sprintf("未找到对应的消息处理服务, topic:%s,event:%s", $wosOpenMessage->getTopic(), $wosOpenMessage->getTopic()));
                $result = ["code"=>["errcode"=>"4900100100004","errmsg"=>sprintf("【业务异常】topic:%s,event:%s 未找到对应的消息处理服务", $wosOpenMessage->getTopic(), $wosOpenMessage->getTopic())]];
                return $response->withJson($result);
            }
            $methodName = SpecTypeEnum::MSG_METHOD_NAME;
            $result = $this->invokeMethod($msgInstance, $wosOpenMessage, $methodName, $wosOpenMessage->getMsgBody());

            return $response->withJson($result);
        }catch (Throwable $ex){
            LogFacade::info(sprintf("failed to invoke message listener service, request: %s, ex: %s", $request->getBody(), $ex->getMessage()));
            $result = ["code"=>["errcode"=>"4900100100004","errmsg"=>sprintf("【业务异常】 执行异常，%s", $ex->getMessage())]];
            return $response->withJson($result);
        }
    }

    private function invokeMethod($msgInstance, WosOpenMessage $wosOpenMessage, $methodName, $msgBodyStr){
        $ref = new ReflectionClass($msgInstance);
        $method = $ref->getMethod($methodName);
        $parameters = $method->getParameters();
        $parameterType = $parameters[0]->getType();

        $refParamClass = new ReflectionClass($parameterType->getName());
        $paramInstance = $refParamClass->newInstanceWithoutConstructor();

        $busiParamType = $ref->getConstant("classType");

        $jsonDecoder = new JsonMapper();
        $busiParamInstance = $jsonDecoder->map(json_decode($msgBodyStr), new $busiParamType());
        $paramInstance->setId($wosOpenMessage->getId());
        $paramInstance->setTopic($wosOpenMessage->getTopic());
        $paramInstance->setEvent($wosOpenMessage->getEvent());
        $paramInstance->setBosId($wosOpenMessage->getBosId());

        $paramInstance->setSign($wosOpenMessage->getSign());
        $paramInstance->setSaasChannel($wosOpenMessage->getSaasChannel());
        $paramInstance->setSaasClientId($wosOpenMessage->getSaasClientId());
        $paramInstance->setMsgBody($busiParamInstance);

        return $method->invoke($msgInstance, $paramInstance);
    }
}