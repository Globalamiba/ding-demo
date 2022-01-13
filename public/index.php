<?php
declare(strict_types=1);

use Phalcon\Exception;
use ding\Bootstrap;

require "vendor/autoload.php";

define('APP_PATH', realpath('..'));
try {
    $boot = new Bootstrap(APP_PATH);
    $boot->run();
}catch (Exception $e) {

}