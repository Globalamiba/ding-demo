<?php
declare(strict_types=1);

use Phalcon\Exception;
use Vagrant\Ding\Bootstrap;

define('APP_PATH', realpath('..'));

try {
    require_once APP_PATH . "/vendor/autoload.php";

    $boot = new Bootstrap(APP_PATH);
    $boot->run();
}catch (Exception $e) {
    echo $e->getMessage();
}