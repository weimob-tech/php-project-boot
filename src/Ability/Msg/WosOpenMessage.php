<?php

namespace WeimobCloudBoot\Ability\Msg;

class WosOpenMessage implements \JsonSerializable
{
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
     * 商业操作系统ID
     * @var string
     */
    public $bosId;

    /**
     * 消息签名
     * @var string
     */
    public $sign;

    /**
     * 是否是测试消息
     * @var bool
     */
    private $test;

    /**
     * 业务消息字符串，编码格式UTF-8
     * @var string
     */
    private $msgBody;


    /**
     * @var string
     */
    private $msgVersion;

    /**
     * @var int
     */
    private $specsType;

    public function jsonSerialize()
    {
        return get_object_vars($this);
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
    public function getBosId(): ?string
    {
        return $this->bosId;
    }

    /**
     * @param string $bosId
     */
    public function setBosId(?string $bosId): void
    {
        $this->bosId = $bosId;
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
}