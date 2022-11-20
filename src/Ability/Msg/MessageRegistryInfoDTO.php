<?php

namespace WeimobCloudBoot\Ability\Msg;

class MessageRegistryInfoDTO implements \JsonSerializable
{
    /**
     * @return mixed
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * @param mixed $clientId
     */
    public function setClientId($clientId): void
    {
        $this->clientId = $clientId;
    }

    /**
     * @return mixed
     */
    public function getHostAddress()
    {
        return $this->hostAddress;
    }

    /**
     * @param mixed $hostAddress
     */
    public function setHostAddress($hostAddress): void
    {
        $this->hostAddress = $hostAddress;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param mixed $path
     */
    public function setPath($path): void
    {
        $this->path = $path;
    }

    /**
     * @return mixed
     */
    public function getSpecsType()
    {
        return $this->specsType;
    }

    /**
     * @param mixed $specsType
     */
    public function setSpecsType($specsType): void
    {
        $this->specsType = $specsType;
    }
    /**
     * client id
     * @var string
     */
    private $clientId;

    /**
     * 实现的地址
     * @var string
     */
    private $hostAddress;

    /**
     * 访问路径
     * @var string
     */
    private $path;

    /**
     * 类型
     * Integer
     */
    private $specsType;

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}