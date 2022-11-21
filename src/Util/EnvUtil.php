<?php

namespace WeimobCloudBoot\Util;

use Exception;
use Monolog\Logger;
use Symfony\Component\Yaml\Yaml;
use WeimobCloudBoot\Ability\SpecTypeEnum;
use WeimobCloudBoot\Boot\BaseFramework;

class EnvUtil extends BaseFramework
{
    private $apolloConfig = [];
    private $localConfig = [];
    private $clientInfos = [];

    const CONFIG_CENTER_FILE_CLOUD = '/tmp/config_center_all.yaml';

    const CONFIG_FILE_LOCAL = '/env.local.yaml';

    const CLIENT_INFO_PREFIX = "weimob.cloud.";

    const CLIENT_ID_SUFFIX = ".clientId";

    const CLIENT_SECRET_SUFFIX = ".clientSecret";

    const WEIMOB_CLOUD_CLIENTID = "weimob.cloud.clientId";

    public static function getConfigFile(): string
    {
        return self::CONFIG_CENTER_FILE_CLOUD;
    }

    public static function getLocalConfigFile(): string
    {
        if (defined('WMCLOUD_BOOT_APP_DIR') && file_exists(WMCLOUD_BOOT_APP_DIR . self::CONFIG_FILE_LOCAL)) {
            return WMCLOUD_BOOT_APP_DIR . self::CONFIG_FILE_LOCAL;
        } else {
            return realpath(__DIR__ . '/../') . self::CONFIG_FILE_LOCAL;
        }
    }

    public function get(String $key) : ?string
    {
        // 1.从配置中心读取
        $val = $this->getFromConfigCenter($key);
        if (!empty($val)) {
            return $val;
        }

        // 2.从本地配置文件中读取
        $val = $this->getFromLocalFile($key);
        if (!empty($val)) {
            return $val;
        }

        // 3.从Env获取
        return $this->getFromEnv($key);
    }

    private function getFromConfigCenter(String $key) : ?string
    {
        $this->loadFile();

        if (is_array($this->apolloConfig) && isset($this->apolloConfig[$key])) {
            return $this->apolloConfig[$key];
        }

        return null;
    }
    private function loadFile()
    {
        if (empty($this->apolloConfig) && file_exists(EnvUtil::getConfigFile())) {
            try {
                $this->apolloConfig = Yaml::parseFile(EnvUtil::getConfigFile());
            } catch (Exception $e) {

            }
        }
    }

    private function getFromLocalFile(String $key) : ?string
    {
        $this->loadLocalFile();

        if (is_array($this->localConfig) && isset($this->localConfig[$key])) {
            return $this->localConfig[$key];
        }

        return null;
    }

    private function loadLocalFile()
    {
        if (empty($this->localConfig) && file_exists(EnvUtil::getLocalConfigFile())) {
            try {
                $this->localConfig = Yaml::parseFile(EnvUtil::getLocalConfigFile());
            } catch (Exception $e) {

            }
        }
    }

    private function getFromEnv(string $key): ?string
    {
        $key = str_replace('.', '_', $key);
        return getenv($key);
    }

    public function getAppName(): ?string
    {
        return $this->get('application.name');
    }

    public function getPostUrl(): ?string
    {
        return getenv('postUrl');
    }

    public function getApolloMetaServer(): ?string
    {
        return getenv('apollo.meta');
    }

    public function getAppId(): ?string
    {
        return getenv('APP_ID');
    }

    public function getWeimobCloudAppId(): ?string
    {
        return getenv('weimob_cloud_appId');
    }

    public function getAppSecret(): ?string
    {
        return $this->get('weimob.cloud.app.secret');
    }

    public function getEnv(): ?string
    {
        return getenv('weimob_cloud_env');
    }

    public function getLogLevel(): int
    {
        $level = $this->get('weimob.cloud.log.level');
        if(strcasecmp("DEBUG", $level) == 0) {
            return Logger::DEBUG;
        } else if(strcasecmp("INFO", $level) == 0) {
            return Logger::INFO;
        } else if(strcasecmp("WARNING", $level) == 0) {
            return Logger::WARNING;
        } else if(strcasecmp("ERROR", $level) == 0) {
            return Logger::ERROR;
        }
        return Logger::INFO;
    }

    /**
     * 获取到host name，实际上是pod name
     * @return string|null
     */
    public static function getHostName(): ?string
    {
        return getenv('SERVER_ADDR');
    }

    public function getClientInfos(): ?array
    {
        if(empty($this->clientInfos)){
            $this->loadFile();
            $this->loadLocalFile();
            $allConfig = array_merge($this->apolloConfig, $this->localConfig);
            foreach ($allConfig as $key => $val)
            {
                if($key === self::WEIMOB_CLOUD_CLIENTID)
                {
                    continue;
                }
                $beginPos = strpos($key,self::CLIENT_INFO_PREFIX);
                if($beginPos === false)
                {
                    continue;
                }
                $temp = str_replace(self::CLIENT_INFO_PREFIX,'',$key);
                //获取.开始到结尾的字符串
                $endKey = strstr($temp,'.',false);
                $clientInfoName = strstr($temp,'.',true);
                if($endKey === self::CLIENT_ID_SUFFIX)
                {
                    if(isset($this->clientInfos[$clientInfoName]) && !empty($this->clientInfos[$clientInfoName]))
                    {
                        $this->clientInfos[$clientInfoName]["clientId"] = (string)$val;
                    }else
                    {
                        $this->clientInfos[$clientInfoName] = ["clientId"=>(string)$val];
                    }
                }else if($endKey === self::CLIENT_SECRET_SUFFIX)
                {
                    if(isset($this->clientInfos[$clientInfoName]) && !empty($this->clientInfos[$clientInfoName]))
                    {
                        $this->clientInfos[$clientInfoName]["clientSecret"] = (string)$val;
                    }else
                    {
                        $this->clientInfos[$clientInfoName] = ["clientSecret"=>(string)$val];
                    }
                }

            }
        }
        return $this->clientInfos;
    }

    public static function getSdkVersion(): string
    {
        return SpecTypeEnum::SDK_VERSION_V2;
    }
}