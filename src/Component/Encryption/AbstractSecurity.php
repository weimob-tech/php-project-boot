<?php

namespace WeimobCloudBoot\Component\Encryption;

use WeimobCloudBoot\Boot\BaseFramework;
class AbstractSecurity extends BaseFramework
{
    
    private $accessToken;
    private $baseUrl;
    private $securityBosPath = '/apigw/bos/v2.0/security/%s?accesstoken=%s';
    private $batchSecurityPath = '/api/1_0/ec/order/%s?accesstoken=%s';

    /**
     * @param string $accessToken
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
    }
    
    /**
     * @param string $baseUrl
     */
    public function setBaseUrl($baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }

    private function buildRequestUrl(string $api, string $type): string
    {
        if($type == 'bos'){
            return $this->baseUrl . sprintf($this->securityBosPath,$api,$this->accessToken);
        }else
        {
            return $this->baseUrl . sprintf($this->batchSecurityPath,$api,$this->accessToken);
        }
    }
    protected function request($api,$requestBody,$type='bos')
    {
        $url = self::buildRequestUrl($api,$type);
        $client = $this->getContainer()->get('httpClient');
        $r = $client->post($url,[],json_encode($requestBody));
        return $r->getBodyAsJson();
    }
}