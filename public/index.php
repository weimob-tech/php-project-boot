<?php

require_once(__DIR__ . '/../boot/functions.php');

initEnv();
fixInnerServerBug();
$container = initContailner();
$app = initApp($container);
initFrameConfig($app);
$wrapper = initAbility($container);
running($app, $wrapper);
