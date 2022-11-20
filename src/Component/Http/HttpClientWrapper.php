<?php

namespace WeimobCloudBoot\Component\Http;

use Psr\Container\ContainerInterface;
use WeimobCloudBoot\Boot\BaseFramework;

class HttpClientWrapper extends BaseFramework
{
    private $curlHandle;

    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);

        $this->init();
    }

    /**
     * 初始化 Client
     *
     * @see HttpClientFactory
     *
     */
    private function init()
    {
        $this->curlHandle = curl_init();
    }

    /**
     * 发起一个 Get 请求并获得返回
     *
     * @param string $url
     * @param array|null $headers
     * @return HttpClientResponse
     */
    public function get(string $url, array $headers = null): HttpClientResponse
    {
        return $this->doRequest('GET', $url, $headers, null);
    }

    /**
     * 对外请求的统一封装
     *
     * @param $method
     * @param $url
     * @param array|null $headers
     * @param null $body
     * @return HttpClientResponse
     */
    protected function doRequest($method, $url, array $headers = null, $body = null)
    {
        curl_setopt($this->curlHandle, CURLOPT_CUSTOMREQUEST, $method);

        curl_setopt($this->curlHandle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($this->curlHandle, CURLOPT_SSL_VERIFYHOST, false);

        if ($headers) {
            curl_setopt($this->curlHandle, CURLOPT_HTTPHEADER, $headers);
        }
        curl_setopt($this->curlHandle, CURLOPT_HEADER, true);
        curl_setopt($this->curlHandle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->curlHandle, CURLOPT_URL, $url);
        curl_setopt($this->curlHandle, CURLOPT_FOLLOWLOCATION, true);
        // 设置一个最大允许重定向的次数防止溢出
        curl_setopt($this->curlHandle, CURLOPT_MAXREDIRS, 10);

        // 消息体
        if (!empty($body)) {
            curl_setopt($this->curlHandle, CURLOPT_POSTFIELDS, $body);
        }

        // Ddebug观察输出的话取消下行注释
        // curl_setopt($this->curlHandle, CURLOPT_VERBOSE, true);

        $response = curl_exec($this->curlHandle);

        $responseHeaderSize = curl_getinfo($this->curlHandle, CURLINFO_HEADER_SIZE);
        $responseCode = curl_getinfo($this->curlHandle, CURLINFO_HTTP_CODE);
        $responseHeaders = substr($response, 0, $responseHeaderSize);
        $responseBody = substr($response, $responseHeaderSize);

        curl_reset($this->curlHandle);

        return new HttpClientResponse($responseCode, $responseHeaders, $responseBody);
    }

    /**
     * 发起一个 Post 请求并获得返回
     *
     * @param string $url
     * @param array|null $headers ['token: 1234']
     * @param string|null $body {"id":1, "hello":"world"}
     * @return HttpClientResponse
     */
    public function post(string $url, array $headers = null, string $body = null): HttpClientResponse
    {
        $realHeaders = ['Content-Type: application/json'];
        if(is_array($headers)) {
            $realHeaders = array_merge($realHeaders, $headers);
        }
        if ($this->isDebug()) {
            $this->getLog()->info(sprintf("Post url: %s, headers: %s", $url, json_encode($realHeaders)));
        }
        return $this->doRequest('POST', $url, $realHeaders, $body);
    }

    /**
     * 发起一个 Put 请求并获得返回
     *
     * @param $url
     * @param array|null $headers
     * @param null $body
     * @return HttpClientResponse
     */
    public function put($url, array $headers = null, $body = null): HttpClientResponse
    {
        if ($this->isDebug()) {
            $this->getLog()->info(sprintf("Put url: %s, headers: %s", $url, json_encode($headers)));
        }
        return $this->doRequest('PUT', $url, $headers, $body);
    }

    /**
     * 发起一个 Delete 请求并获得返回
     *
     * @param $url
     * @param array|null $headers
     * @return HttpClientResponse
     */
    public function delete($url, array $headers = null): HttpClientResponse
    {
        if ($this->isDebug()) {
            $this->getLog()->info(sprintf("Delete url: %s, headers: %s", $url, json_encode($headers)));
        }
        return $this->doRequest('DELETE', $url, $headers, null);
    }
}