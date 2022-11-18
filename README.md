# php-project-boot
微盟云开放平台的PHP项目工程启动脚手架，提供一套PHP工程的标准规范，开发者更多关注业务本身，减少开发成本，使其可以快速接入微盟云的开放生态。

## 介绍
### 功能列表
* 脚手架框架
* 能力实现
	* SPI实现注册路由
	* MSG订阅路由
* 组件列表
	* PDO封装
	* MySQL封装
	* Redis封装
	* Log组件封装
	* Oauth封装
	* Encryption封装
	* HttpClient封装
	* Apollo封装

### 项目结构

```
|-- composer.json
|-- README.md
|-- LICENSE
|-- .gitignore
|-- bin/                         # bash脚本目录
|-- boot/                        # 框架脚本目录
|-- public/                      # 公开脚本目录
|-- src/                         # 源码目录
|   |-- Ability/                 # 开放能力
|       |-- Spi/                 # SPI能力注册发布
|       |-- Msg/                 # MSG订阅发布
|   |-- Boot/                    # 框架类
|   |-- Controller/              # 框架基础实现，health_check、能力路由...
|   |-- Component/               # 组件列表
|       |-- Store/               # 存储相关组件，PDO、MySQL、Redis
|       |-- Apollo/              # Apollo配置组件
|       |-- Http/                # HttpClient组件
|       |-- Log/                 # 日志组件
|       |-- Oauth/               # Oauth授权组件
|       |-- Encryption/          # 加解密组件
|   |-- Daemon/                  # 守护进程目录
|   |-- Exception/               # 异常
|   |-- Facade/                  # 组件代理类
|   |-- Util/                    # 工具类
|-- test/
```

## 快速开始
1. 使用composer管理包，在php项目工程的composer.json添加依赖
	
	``` json
	"require": {
		... 
		"weimob-cloud/php-wos-spi-sdk": "${last_version}",
		"weimob-cloud/php-wos-msg-sdk": "${last_version}",
		"weimob-cloud/php-xinyun-spi-sdk": "${last_version}",
		"weimob-cloud/php-xinyun-msg-sdk": "${last_version}"
	}
	```
2. 安装包，使用composer命令
	* composer install
	* composer update
	* composer dumpautoload
	* composer ... [详细文档](https://getcomposer.org/)
3. 本地调试启

	``` bash
	--xdebug 启动
	php -d variables_order=EGPCS -dxdebug.remote_enable=1 -dxdebug.remote_mode=req -dxdebug.remote_port=9000 -dxdebug.remote_host=127.0.0.1 -dxdebug.remote_autostart=1 -S localhost:18888 -t ../public ../public/index.php
	-- 后台启动
	php -d variables_order=EGPCS -S localhost:18888 -t ../public ../public/index.php
	``` 
4. 生产环境运行，可以在微盟云开发平台进行构建镜像，并发布到容器集群

## 使用文档
* [能力文档](http://doc.weimobcloud.com/list?tag=2396&menuId=19&childMenuId=1&isold=2)
* [开发者入驻](http://doc.weimobcloud.com/word?menuId=46&childMenuId=47&tag=2970&isold=2)
* [应用开发](http://doc.weimobcloud.com/word?menuId=53&childMenuId=54&tag=2488&isold=2)
* [PHP工程](http://doc.weimobcloud.com/word?menuId=53&childMenuId=54&tag=2488&isold=2)

## 贡献方法
* 申请加入weimob_tech

## 联系我们
* Weimob-tech@weimob.com
