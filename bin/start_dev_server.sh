#!/bin/bash

path=$(cd `dirname $0`;pwd)
daemonPhp=${path}"/../boot/daemon.php"
webRoot=${path}"/../public"
routePhp=${path}"/../public/index.php"

if [ "$1" = "-d" ]; then
    php -d variables_order=EGPCS -d xdebug.remote_enable=1 -d xdebug.remote_mode=req -d xdebug.remote_port=9000 -d xdebug.remote_host=127.0.0.1 -d xdebug.remote_autostart=1 -S localhost:18888 -t $webRoot $routePhp
else
    php -d variables_order=EGPCS -S localhost:18888 -t $webRoot $routePhp
fi