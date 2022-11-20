<?php

namespace WeimobCloudBoot\Util;

use Exception;
use Symfony\Component\Yaml\Yaml;
use WeimobCloudBoot\Boot\BaseFramework;
use WeimobCloudBoot\Component\Http\HttpClientResponse;

class ApolloUtil extends BaseFramework
{
    public function writeToFile($reties = 3)
    {
        if ($reties < 0) {
            //LogFacade::warn("Apollo writeToFile. exceeds the maximum retries");
        } else {
            $configAll = array_merge($this->get('system'), $this->get('application'));
            if (empty($configAll)) {
                //LogFacade::warn("Apollo writeToFile. the configAll empty");
                $this->writeToFile(--$reties);
            } else {
                // write to file
                $res = file_put_contents(EnvUtil::getConfigFile(), Yaml::dump($configAll));
                if (false === $res) {
                    //LogFacade::warn("Apollo writeToFile. write return false");
                    $this->writeToFile(--$reties);
                }
            }
        }
    }


    /**
     * 获取Apollo资源配置项
     *
     * @param string $resource system\application
     * @return array
     */
    private function get(string $resource): array
    {
        return $this->pull($resource);
    }


    /**
     * 拉取资源配置
     *
     * @param string $resource
     * @return array
     */
    private function pull(string $resource): array
    {
        try {
            /** @var HttpClientResponse $resp */
            $resp = $this->getContainer()->get('httpClient')->get($this->buildHttpUrl($resource), $this->buildHttpHeaders());
            if (empty($resp->getBodyAsJson()) || !isset($resp->getBodyAsJson()['configurations'])) {
                return [];
            }

            return $resp->getBodyAsJson()['configurations'];
        } catch (Exception $e) {
            //LogFacade::err('ApolloUtil pull, exception: ' . $e->getTraceAsString());
        }

        return [];
    }


    /**
     * 构造请求URL
     *
     * @param $resources string 资源名:system\application
     * @return string
     */
    private function buildHttpUrl($resources): string
    {
        $env = $this->getEnvUtil();

        return sprintf(
            "%s/configs/%s/default/%s", $env->getApolloMetaServer(), $env->getAppId(), $resources
        );
    }


    /**
     * 构造请求头
     *
     * @return array
     */
    private function buildHttpHeaders(): array
    {
        $env = $this->getEnvUtil();

        return [
            sprintf("auth: %s;%s", $env->getAppId(), $env->getAppSecret())
        ];
    }
}