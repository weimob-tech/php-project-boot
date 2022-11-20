<?php

namespace WeimobCloudBoot\Ability\Msg;

class MsgInfo
{
    /**
     * @return string
     */
    public function getTopic(): string
    {
        return $this->topic;
    }

    /**
     * @param string $topic
     */
    public function setTopic(string $topic): void
    {
        $this->topic = $topic;
    }

    /**
     * @return string
     */
    public function getEvent(): string
    {
        return $this->event;
    }

    /**
     * @param string $event
     */
    public function setEvent(string $event): void
    {
        $this->event = $event;
    }
    /**
     * topic
     * @var string
     */
    private $topic;

    /**
     * event
     * @var string
     */
    private $event;

    public function __construct($topic, $event)
    {
        $this->topic = $topic;
        $this->event = $event;
    }
}