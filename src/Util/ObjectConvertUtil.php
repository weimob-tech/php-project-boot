<?php

namespace WeimobCloudBoot\Util;

use ReflectionClass;
use ReflectionMethod;
use WeimobCloudBoot\Boot\BaseFramework;
use WeimobCloudBoot\Exception\SpiHandleException;

class ObjectConvertUtil extends BaseFramework
{

    /**
     * 把字符串格式对象转换为方法的入参对象
     * @param ReflectionMethod $method
     * @param $input 字符串格式对象
     * @return mixed|object|null
     */
    public function convertToMethodParameter(ReflectionMethod $method, $input)
    {
        if (count($method->getParameters()) > 1) {
            // 严格限定参数只有0个或者1个
            throw new SpiHandleException('The number of spi parameters  exceed 1');
        }

        if (count($method->getParameters()) == 0) {
            return null;
        }

        $parameter = current($method->getParameters());
        $type = $parameter->getType();

        switch ($type->getName()) {
            case 'string':
            case 'int':
            case 'bool':
            case 'float':
            case 'array':
                return $input;
            case 'callable':
            case 'iterable':
            case 'object':
                throw new SpiHandleException('Unsupported parameter type');
        }

        $refParameterClass = new ReflectionClass($type->getName());

        return $this->convertToObject($input, $refParameterClass);
    }

    /**
     * 把字符串格式对象转换为方法参数反射类对应的对象
     * @param $input 字符串格式对象
     * @param ReflectionClass $refParameterClass
     * @return mixed|object|null
     */
    public function convertToObject($input, ReflectionClass $refParameterClass)
    {
        if (is_null($input)) {
            return $input;
        }

        // 匿名类直接转换
        if ($refParameterClass->getName() == 'stdClass') {
            if (empty($input)) {
                return (object) $input;
            } else {
                return json_decode(json_encode($input));
            }
        }

        $instance = $refParameterClass->newInstanceWithoutConstructor();

        foreach ($input as $propertyName => $propertyValue) {
            $methodName = 'set' . ucfirst($propertyName);
            if (!$refParameterClass->hasMethod($methodName)) {
                // 没有setter方法则跳过此属性
                continue;
            }
            $setter = $refParameterClass->getMethod($methodName);
            if (is_array($propertyValue)) {
                $matches = [];
                preg_match('/@param ([A-Za-z0-9_\\\\]+)((?:\[\])+)/', $setter->getDocComment(), $matches);

                if (is_scalar($propertyValue) || empty($matches)) {
                    $setter->invoke($instance, $this->convertToMethodParameter($setter, $propertyValue));
                } else {
                    $listLevelsCount = substr_count(end($matches), '[]');
                    $memberType = $this->fillUpNamespaceWithType($matches[1], $refParameterClass->getNamespaceName());

                    $setter->invoke($instance, $this->diveIntoMatrix($propertyValue, $memberType, $listLevelsCount));
                }
            } else {
                $setterRefParams = $setter->getParameters();
                // 约定 Setter 只有一个参数，这里对 DateTime 类型进行特殊处理
                if ($setterRefParams[0]->getType()->getName() == 'DateTime') {
                    $setter->invoke($instance, $this->parseTimestampOrDateString($propertyValue));
                } else {
                    $setter->invoke($instance, $propertyValue);
                }
            }
        }

        return $instance;
    }

    private function fillUpNamespaceWithType($typeName, $refClassNamespace)
    {
        if ($this->isPrimitiveType($typeName) || $typeName == 'stdClass' || $typeName == 'DateTime') {
            return $typeName;
        } else {
            /**
             * 这个判断可能有点过于粗暴, 但是暂时也没有想到更好的办法
             */
            if (strpos($typeName, '\\') !== false) {
                return $typeName;
            } else {
                return $refClassNamespace . '\\' . $typeName;
            }
        }
    }

    /**
     *
     * @see http://php.net/manual/en/function.gettype.php reference
     * @param string $type
     * @return bool
     */
    private function isPrimitiveType(string $type): bool
    {
        switch ($type) {
            case 'string':
            case 'integer':
            case 'double':
            case 'boolean':
            case 'NULL':
            case 'int':
            case 'number':
            case 'bool':
            case 'float':
                return true;
        }
        return false;
    }

    private function diveIntoMatrix($propertyValue, $memberType, $levels)
    {
        if ($this->isPrimitiveType($memberType)) {
            return $propertyValue;
        }
        if ($levels > 1) {
            $r = [];
            foreach ($propertyValue as $item) {
                $r[] = $this->diveIntoMatrix($item, $memberType, $levels - 1);
            }
            return $r;
        }

        if ($memberType == 'DateTime') {
            $instanceValues = array_map(function($item) {
                return $this->parseTimestampOrDateString($item);
            }, $propertyValue);
            return $instanceValues;
        }

        $ref = new ReflectionClass($memberType);
        $instanceValues = array_map(function ($item) use ($ref) {
            return $this->convertArrayToObjectInstance($item, $ref);
        }, $propertyValue);

        return $instanceValues;
    }

    /**
     * @param $item
     * @return DateTime
     * @throws SpiHandleException
     * @throws Exception
     */
    private function parseTimestampOrDateString($item)
    {
        if (is_numeric($item)) {
            $dateObj = new DateTime();
            return $dateObj->setTimestamp($item / 1000); // 处理的都是 Java 的毫秒级时间戳
        } else if (is_string($item)) {
            return new DateTime($item);
        } else {
            throw new SpiHandleException('Cannot parse datetime value: ' . $item);
        }
    }
}