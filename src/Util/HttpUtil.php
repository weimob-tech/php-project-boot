<?php

namespace WeimobCloudBoot\Util;

class HttpUtil
{
    public static function post($url, $params = [], $headers = []): string
    {
        $client = new \GuzzleHttp\Client();

        $response = $client->request(
            'POST',
            $url,
            self::buildPostOptional($params, $headers)
        );
        return $response->getBody()->getContents();
    }

    public static function get($url, $params = [], $headers = []): string
    {
        $client = new \GuzzleHttp\Client();

        $response = $client->request(
            'GET',
            $url,
            self::buildGetOptional($params, $headers)
        );
        return $response->getBody()->getContents();
    }

    private static function buildPostOptional($params = [], $headers = []): array
    {
        $ret = [
            'headers' => $headers,
        ];

        $ret['headers']['Content-Type'] = 'application/json';
        $ret['body'] = self::buildBody($params);
        return $ret;
    }

    private static function buildGetOptional($params = [], $headers = []): array
    {
        $ret = [
            'headers' => $headers,
        ];

        $ret['query'] = $params;
        return $ret;
    }

    private static function buildBody($params)
    {
        if (empty($params)) {
            return '{}';
        }

        return json_encode($params);
    }
}