#!/bin/bash

path=$(cd `dirname $0`;pwd)
daemonPhp=${path}"/../boot/daemon.php"
webRoot=${path}"/../public"
routePhp=${path}"/../public/index.php"

#php $daemonPhp start
php -S 0.0.0.0:8080 -t $webRoot $routePhp