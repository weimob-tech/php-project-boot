<?php

namespace WeimobCloudBoot\Ability;

class SpecTypeEnum
{
    const XINYUN = 1;
    const WOS = 2;
    const WOS_SPI_METHOD_NAME = "invoke";
    const XINYUN_SPI_METHOD_NAME = "execute";

    const WOS_SPI_INTERFACE_CLASS_PACKAGE = 'WeimobAbility\Weimob\Wos\Cloud\Spi';
    const XINYUN_SPI_INTERFACE_CLASS_PACKAGE = 'WeimobAbility\Weimob\Xinyun\Cloud\Spi';

    const WOS_MSG_INTERFACE_CLASS_PACKAGE = 'WeimobAbility\Weimob\Wos\Cloud\Msg';
    const XINYUN_MSG_INTERFACE_CLASS_PACKAGE = 'WeimobAbility\Weimob\Xinyun\Cloud\Msg';

    const MSG_METHOD_NAME='onMessage';

    const SDK_VERSION_V1 = "v1";
    const SDK_VERSION_V2 = "v2";
}