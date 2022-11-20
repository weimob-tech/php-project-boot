<?php

namespace WeimobCloudBoot\Ability\Spi;

class SpiRegistryInfoDTO implements \JsonSerializable
{
    /**
     * @return mixed
     */
    public function getImplFullName()
    {
        return $this->implFullName;
    }

    /**
     * @param mixed $implFullName
     */
    public function setImplFullName($implFullName): void
    {
        $this->implFullName = $implFullName;
    }

    /**
     * @return mixed
     */
    public function getInterfaceName()
    {
        return $this->interfaceName;
    }

    /**
     * @param mixed $interfaceName
     */
    public function setInterfaceName($interfaceName): void
    {
        $this->interfaceName = $interfaceName;
    }

    /**
     * @return mixed
     */
    public function getBeanName()
    {
        return $this->beanName;
    }

    /**
     * @param mixed $beanName
     */
    public function setBeanName($beanName): void
    {
        $this->beanName = $beanName;
    }

    /**
     * @return mixed
     */
    public function getMethodName()
    {
        return $this->methodName;
    }

    /**
     * @param mixed $methodName
     */
    public function setMethodName($methodName): void
    {
        $this->methodName = $methodName;
    }

    /**
     * @return mixed
     */
    public function getSpiBelongType()
    {
        return $this->spiBelongType;
    }

    /**
     * @param mixed $spiBelongType
     */
    public function setSpiBelongType($spiBelongType): void
    {
        $this->spiBelongType = $spiBelongType;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }

    /**
     * 实现的的全类名
     * string
     */
    private  $implFullName;

    /**
     * spi接口的简单类名，如：OrderService
     * @var string
     */
    private $interfaceName;

    /**
     * spring 容器中的bean name
     * @var string
     */
    private $beanName;

    /**
     * 方法名
     * @var string
     */
    private $methodName;

    /**
     * spi的归属类型
     * Integer
     */
    private $spiBelongType;
}