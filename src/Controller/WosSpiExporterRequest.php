<?php

namespace WeimobCloudBoot\Controller;

class WosSpiExporterRequest implements \JsonSerializable
{
    /**
     * 签名
     * @var string
     */
    private $sign;

    /**
     * 发送方时间戳，验签的时候使用
     * @var string
     */
    private $timestamp;

    /**
     * 商业操作系统ID（产品体系）
     * Long
     */
    private $bosId;

    /**
     * 功能集id
     * Long
     */
    private $functionId;

    /**
     * 虚拟id
     * Long
     */
    private $vid;

    /**
     * 虚拟节点类型
     * Long
     */
    private $vType;

    /**
     * 业务入参,后续需要反序列化
     * @var string
     */
    private $params;

    /**
     * @return mixed
     */
    public function getSign()
    {
        return $this->sign;
    }

    /**
     * @param mixed $sign
     */
    public function setSign($sign): void
    {
        $this->sign = $sign;
    }

    /**
     * @return mixed
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @param mixed $timestamp
     */
    public function setTimestamp($timestamp): void
    {
        $this->timestamp = $timestamp;
    }

    /**
     * @return mixed
     */
    public function getBosId()
    {
        return $this->bosId;
    }

    /**
     * @param mixed $bosId
     */
    public function setBosId($bosId): void
    {
        $this->bosId = $bosId;
    }

    /**
     * @return mixed
     */
    public function getFunctionId()
    {
        return $this->functionId;
    }

    /**
     * @param mixed $functionId
     */
    public function setFunctionId($functionId): void
    {
        $this->functionId = $functionId;
    }

    /**
     * @return mixed
     */
    public function getVid()
    {
        return $this->vid;
    }

    /**
     * @param mixed $vid
     */
    public function setVid($vid): void
    {
        $this->vid = $vid;
    }

    /**
     * @return mixed
     */
    public function getVType()
    {
        return $this->vType;
    }

    /**
     * @param mixed $vType
     */
    public function setVType($vType): void
    {
        $this->vType = $vType;
    }

    /**
     * @return mixed
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @param mixed $params
     */
    public function setParams($params): void
    {
        $this->params = $params;
    }



    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}