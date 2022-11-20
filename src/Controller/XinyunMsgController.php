<?php

namespace WeimobCloudBoot\Controller;

use JsonMapper;
use ReflectionClass;
use Slim\Http\Request;
use Slim\Http\Response;
use Throwable;
use WeimobCloudBoot\Ability\Msg\MsgInfo;
use WeimobCloudBoot\Ability\Msg\MsgSubscription;
use WeimobCloudBoot\Ability\Msg\XinyunOpenMessage;
use WeimobCloudBoot\Ability\SpecTypeEnum;
use WeimobCloudBoot\Boot\BaseFramework;
use WeimobCloudBoot\Facade\LogFacade;

class XinyunMsgController extends BaseFramework
{
    public function handle(Request $request, Response $response, array $args){
        try {
            $msgBody = $request->getParsedBody();

            $jsonDecoder = new JsonMapper();
            /** @var XinyunOpenMessage $xinyunOpenMessage */
            $xinyunOpenMessage = $jsonDecoder->map($msgBody, new XinyunOpenMessage());
            $msgInfo = new MsgInfo($xinyunOpenMessage->getTopic(), $xinyunOpenMessage->getEvent());

            $specType = $xinyunOpenMessage->getSpecsType();
            if (empty($specType)) {
                $specType = SpecTypeEnum::WOS;
            }

            $msgSubscription = $this->getContainer()->get("msgSubscription");

            /** @var MsgSubscription $msgSubscription */
            $msgInstance = $msgSubscription->getMsg($msgInfo, $specType);
            if(empty($msgInstance))
            {
                LogFacade::info(sprintf("未找到对应的消息处理服务, topic:%s,event:%s", $xinyunOpenMessage->getTopic(), $xinyunOpenMessage->getTopic()));
                $result = ["code"=>["errcode"=>"4900100100004","errmsg"=>sprintf("【业务异常】topic:%s,event:%s 未找到对应的消息处理服务", $xinyunOpenMessage->getTopic(), $xinyunOpenMessage->getTopic())]];
                return $response->withJson($result);
            }
            $methodName = SpecTypeEnum::MSG_METHOD_NAME;
            $result = $this->invokeMethod($msgInstance, $xinyunOpenMessage, $methodName, $xinyunOpenMessage->getMsgBody());

            return $response->withJson($result);
        }catch (Throwable $ex){
            LogFacade::info(sprintf("failed to invoke message listener service, request: %s, ex: %s", $request->getBody(), $ex->getMessage()));
            $result = ["code"=>["errcode"=>"4900100100004","errmsg"=>sprintf("【业务异常】 执行异常，%s", $ex->getMessage())]];
            return $response->withJson($result);
        }
    }

    private function invokeMethod($msgInstance, XinyunOpenMessage $xinyunOpenMessage, $methodName, $msgBodyStr)
    {
        $ref = new ReflectionClass($msgInstance);
        $method = $ref->getMethod($methodName);
        $parameters = $method->getParameters();
        $parameterType = $parameters[0]->getType();

        $refParamClass = new ReflectionClass($parameterType->getName());
        $paramInstance = $refParamClass->newInstanceWithoutConstructor();

        $busiParamType = $ref->getConstant("classType");

        $jsonDecoder = new JsonMapper();
        $busiParamInstance = $jsonDecoder->map(json_decode($msgBodyStr), new $busiParamType());
        $paramInstance->setId($xinyunOpenMessage->getId());
        $paramInstance->setTopic($xinyunOpenMessage->getTopic());
        $paramInstance->setEvent($xinyunOpenMessage->getEvent());
        $paramInstance->setBusinessId($xinyunOpenMessage->getBusinessId());
        $paramInstance->setPublicAccountId($xinyunOpenMessage->getPublicAccountId());
        $paramInstance->setSign($xinyunOpenMessage->getSign());
        $paramInstance->setMsgSignature($xinyunOpenMessage->getMsgSignature());
        $paramInstance->setMsgBody($busiParamInstance);

        return $method->invoke($msgInstance, $paramInstance);
    }
}