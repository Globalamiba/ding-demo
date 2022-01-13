<?php
declare(strict_types=1);

use Phalcon\Exception;
use ding\Bootstrap;

define('APP_PATH', realpath('..'));
require_once APP_PATH . "/vendor/autoload.php";

try {
    $boot = new Bootstrap(APP_PATH);
    $boot->run();
}catch (Exception $e) {

}