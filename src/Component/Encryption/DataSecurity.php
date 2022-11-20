<?php

namespace WeimobCloudBoot\Component\Encryption;

class DataSecurity extends AbstractSecurity
{
    /**
     * 数据是否加密 用于判断指定数据是否已加密。
     */
    public function isEncrypt(string $source)
    {    
        return self::request('isEncrypt',self::buildBody($source));
    }

    /**
     * 数据加密 用于单项数据加密。
     * @parame string $source 待加密字段
     */
    public function encrypt(string $source)
    {   
        // echo $source;
        return self::request('encrypt',self::buildBody($source));
    }

    /**
     * 数据解密 用于单项数据解密。
     */
    public function decrypt(string $source)
    {
        return self::request('decrypt',self::buildBody($source));
    }

    private function buildBody(string $source): array
    {
        return [
            'source' => $source,
        ];
    }

}