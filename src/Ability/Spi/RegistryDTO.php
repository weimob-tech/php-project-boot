<?php

namespace WeimobCloudBoot\Ability\Spi;

use WeimobCloudBoot\Ability\Msg\MessageRegistryInfoDTO;

class RegistryDTO implements \JsonSerializable
{
    /**
     * @return mixed
     */
    public function getSdkVersion()
    {
        return $this->sdkVersion;
    }

    /**
     * @param mixed $sdkVersion
     */
    public function setSdkVersion($sdkVersion): void
    {
        $this->sdkVersion = $sdkVersion;
    }

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
    public function getInterfacePathVos()
    {
        return $this->interfacePathVos;
    }

    /**
     * @param mixed $interfacePathVos
     */
    public function setInterfacePathVos($interfacePathVos): void
    {
        $this->interfacePathVos = $interfacePathVos;
    }

    /**
     * @return mixed
     */
    public function getMessageExtensionDTO()
    {
        return $this->messageExtensionDTO;
    }

    /**
     * @param mixed $messageExtensionDTO
     */
    public function setMessageExtensionDTO($messageExtensionDTO): void
    {
        $this->messageExtensionDTO = $messageExtensionDTO;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }

    private $sdkVersion;

    /**
     * client id
     * @var string
     */
    private $clientId;

    /**
     * spi service实现的信息
     * @var array[SpiRegistryInfoDTO]
     */
    private $interfacePathVos;

    /**
     * message实现的信息
     * @var MessageRegistryInfoDTO
     */
    private $messageExtensionDTO;
}