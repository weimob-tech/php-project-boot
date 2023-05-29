<?php

namespace WeimobCloudBoot\Ability\Msg;

class XinyunOpenMessage implements \JsonSerializable
{
    /**
     * 消息模式 1推送至服务商消息 2推送至商户个人
     * @var int
     */
    public $model;

    /**
     * 微盟业务系统消息id，如智慧餐厅的订单编号
     * @var string
     */
    public $id;

    /**
     * 业务消息主题，如智慧餐厅单消息
     * @var string
     */

    public $topic;

    /**
     * topic消息事件类型，如智慧餐厅取消订单事件
     * @var string
     */
    public $event;

    /**
     * 商户id
     * @var string
     */
    public $businessId;

    /**
     * 商户公账号id
     * @var string
     */
    private $publicAccountId;

    /**
     * 业务消息字符串，编码格式UTF-8
     * @var string
     */
    private $msgBody;


    /**
     * 消息的版本号，以最高版本为最新消息，可以覆盖低版本消息，默认1开始
     * @var int
     */
    public $version;

    /**
     * @var string
     */
    public $clientId;

    /**
     * @var array(string)
     */
    public $clientIds;

    /**
     * 签名
     * @var string
     */
    public $sign;

    /**
     * 消息签名
     * @var string
     */
    public $msgSignature;

    /**
     * 是否是测试消息
     * @var bool
     */
    private $test;

    /**
     * @var string
     */
    private $msgVersion;

    /**
     * @var int
     */
    private $specsType;

    /**
     * saas渠道
     * @var string
     */
    private $saas_channel;

    /**
     * saas客户端id
     * @var string
     */
    private $saas_clientId;

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }

    /**
     * @return int
     */
    public function getModel(): ?int
    {
        return $this->model;
    }

    /**
     * @param int $model
     */
    public function setModel(?int $model): void
    {
        $this->model = $model;
    }

    /**
     * @return string
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(?string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getTopic(): ?string
    {
        return $this->topic;
    }

    /**
     * @param string $topic
     */
    public function setTopic(?string $topic): void
    {
        $this->topic = $topic;
    }

    /**
     * @return string
     */
    public function getEvent(): ?string
    {
        return $this->event;
    }

    /**
     * @param string $event
     */
    public function setEvent(?string $event): void
    {
        $this->event = $event;
    }

    /**
     * @return string
     */
    public function getBusinessId(): ?string
    {
        return $this->businessId;
    }

    /**
     * @param string $businessId
     */
    public function setBusinessId(?string $businessId): void
    {
        $this->businessId = $businessId;
    }

    /**
     * @return string
     */
    public function getPublicAccountId(): ?string
    {
        return $this->publicAccountId;
    }

    /**
     * @param string $publicAccountId
     */
    public function setPublicAccountId(?string $publicAccountId): void
    {
        $this->publicAccountId = $publicAccountId;
    }

    /**
     * @return string
     */
    public function getMsgBody(): ?string
    {
        return $this->msgBody;
    }

    /**
     * @param string $msgBody
     */
    public function setMsgBody(?string $msgBody): void
    {
        $this->msgBody = $msgBody;
    }

    /**
     * @return int
     */
    public function getVersion(): ?int
    {
        return $this->version;
    }

    /**
     * @param int $version
     */
    public function setVersion(?int $version): void
    {
        $this->version = $version;
    }

    /**
     * @return string
     */
    public function getClientId(): ?string
    {
        return $this->clientId;
    }

    /**
     * @param string $clientId
     */
    public function setClientId(?string $clientId): void
    {
        $this->clientId = $clientId;
    }

    /**
     * @return array
     */
    public function getClientIds(): ?array
    {
        return $this->clientIds;
    }

    /**
     * @param array $clientIds
     */
    public function setClientIds(?array $clientIds): void
    {
        $this->clientIds = $clientIds;
    }

    /**
     * @return string
     */
    public function getSign(): ?string
    {
        return $this->sign;
    }

    /**
     * @param string $sign
     */
    public function setSign(?string $sign): void
    {
        $this->sign = $sign;
    }

    /**
     * @return string
     */
    public function getMsgSignature(): ?string
    {
        return $this->msgSignature;
    }

    /**
     * @param string $msgSignature
     */
    public function setMsgSignature(?string $msgSignature): void
    {
        $this->msgSignature = $msgSignature;
    }

    /**
     * @return bool
     */
    public function isTest(): ?bool
    {
        return $this->test;
    }

    /**
     * @param bool $test
     */
    public function setTest(?bool $test): void
    {
        $this->test = $test;
    }

    /**
     * @return string
     */
    public function getMsgVersion(): ?string
    {
        return $this->msgVersion;
    }

    /**
     * @param string $msgVersion
     */
    public function setMsgVersion(?string $msgVersion): void
    {
        $this->msgVersion = $msgVersion;
    }

    /**
     * @return int
     */
    public function getSpecsType(): ?int
    {
        return $this->specsType;
    }

    /**
     * @param int $specsType
     */
    public function setSpecsType(?int $specsType): void
    {
        $this->specsType = $specsType;
    }

    /**
     * @return string
     */
    public function getSaasChannel(): ?string
    {
        return $this->saas_channel;
    }

    /**
     * @param string $saas_channel
     */
    public function setSaasChannel(?string $saas_channel): void
    {
        $this->saas_channel = $saas_channel;
    }

    /**
     * @return string
     */
    public function getSaasClientId(): ?string
    {
        return $this->saas_clientId;
    }

    /**
     * @param string $saas_clientId
     */
    public function setSaasClientId(?string $saas_clientId): void
    {
        $this->saas_clientId = $saas_clientId;
    }
}