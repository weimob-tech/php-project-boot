<?php

namespace WeimobCloudBoot\Component\Oauth;
use WeimobCloudBoot\Boot\BaseFramework;
use Psr\Container\ContainerInterface;
class AbstractToken extends BaseFramework
{
        /**
     * @var string The user agent string passed to services
     */
    protected $userAgent = 'WeimobCloudBootToken';

    private $baseUrl;
    private $tokenPath = '/fuwu/b/oauth2/token';

    private $clientId;
    private $clientSecret;

    public function __construct(ContainerInterface $container)
    {   
        $this->_container = $container;
    }
    public function setClientId($clientId){
        $this->clientId = $clientId;
    }
    public function setClientSecret($clientSecret){
        $this->clientSecret = $clientSecret;
    }
    public function setBaseUrl($baseUrl)
    {
        $this->baseUrl = $baseUrl;        
    }
    protected function request($requestBody)
    {
        $requestBody['client_id'] = $this->clientId;
        $requestBody['client_secret'] = $this->clientSecret;
        $buildTokenUrl = $this->buildTokenUrl($requestBody);
        $client = $this->getContainer()->get('httpClient');
        $r = $client->post($buildTokenUrl, self::normalizeHeaders(), json_encode($requestBody));
        return $r->getBodyAsJson();
    }
    private function buildTokenUrl($parames): string
    {
        return $this -> baseUrl . $this -> tokenPath . self::normalizeParames($parames);
    }
    private function normalizeParames($parames): string
    {
        $combined = "?";
        $valueArr = array();

        foreach($parames as $key => $val){
            $valueArr[] = "$key=$val";
        }

        $keyStr = implode("&",$valueArr);
        $combined .= ($keyStr);
        
        return $combined;
    }
    private function normalizeHeaders(): array
    {
        $normalizeHeaders = [
            'User-Agent'=> $this->userAgent,
        ];
        return $normalizeHeaders;
    }
}