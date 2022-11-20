<?php

namespace WeimobCloudBoot\Ability;

use WeimobCloudBoot\Ability\Spi\RegistryDTO;
use WeimobCloudBoot\Component\Http\HttpClientWrapper;
use WeimobCloudBoot\Exception\BeanRegisterException;
use WeimobCloudBoot\Facade\LogFacade;

trait AbilityRemoteRegistry
{
    public function registerRemote(RegistryDTO $registryDTO)
    {
        /** @var \WeimobCloudBoot\Util\EnvUtil $envUtil */
        $envUtil = $this->getContainer()->get("envUtil");
        $clientInfos = $envUtil->getClientInfos();
        if(empty($clientInfos))
        {
            throw new BeanRegisterException("client info is null");
        }
        foreach ($clientInfos as $key=>$val)
        {
            $messageExtensionDto = $registryDTO->getMessageExtensionDTO();
            if(!empty($messageExtensionDto)){
                $messageExtensionDto->setClientId($clientInfos[$key]["clientId"]);
            }
            $this->registerRemoteWithClient($registryDTO, $clientInfos[$key]);
        }
    }

    private function registerRemoteWithClient(RegistryDTO $registryDTO, $clientInfo):void
    {
        /** @var \WeimobCloudBoot\Util\EnvUtil $envUtil */
        $envUtil = $this->getContainer()->get("envUtil");
        $postUrl = $envUtil->getPostUrl();
        if (empty($postUrl)) {
            return;
        }
        /** @var \WeimobCloudBoot\Util\EnvUtil $envUtil */
        $envUtil = $this->getContainer()->get("envUtil");

        $clientId = $clientInfo['clientId'];
        $clientSecret = $clientInfo['clientSecret'];
        $registryDTO->setClientId($clientId);
        $registryDTO->setSdkVersion($envUtil->getSdkVersion());

        $appId = $envUtil->getWeimobCloudAppId();
        $env = $envUtil->getEnv();
        $param = json_encode($registryDTO);
        $timestamp = (string)time();
        $builder = $clientId.$clientSecret.$timestamp.md5($param);
        $sign = md5($builder);

        $myArray = ["sign"=>$sign, "timestamp"=>$timestamp, "clientId"=>$clientId, "appId"=>$appId, "env"=>$env, "params"=>$param];

        /** @var HttpClientWrapper $client */
        $client = $this->getContainer()->get('httpClient');
        $myArrayJsonStr = json_encode($myArray);
        try {
            LogFacade::info("注册信息: $myArrayJsonStr");
            $r = $client->post($postUrl, null, json_encode($myArray));
            $response = $r->getBody();
            LogFacade::info("注册返回信息：$response");
        }catch (\Throwable $ex){
            LogFacade::info("注册容器信息失败。");
            throw new BeanRegisterException("注册容器信息失败");
        }

    }
}