<?php
declare(strict_types=1);

use Phalcon\Exception;
use Vagrant\Ding\Bootstrap;

define('APP_PATH', realpath('..'));
define('TOP_SDK_WORK_DIR', realpath('..') . '/storage/dingTmp');

try {
    require_once APP_PATH . "/vendor/autoload.php";
    include_once APP_PATH . '/libs/TopSdk.php';

    $boot = new Bootstrap(APP_PATH);
    $boot->run();
}catch (Exception $e) {
    echo $e->getMessage();
}