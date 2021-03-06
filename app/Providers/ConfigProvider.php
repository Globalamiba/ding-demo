<?php
declare(strict_types = 1);

namespace Vagrant\Ding\Providers;

use Phalcon\Di\ServiceProviderInterface;
use Phalcon\Di\DiInterface;
use Phalcon\Config;

class ConfigProvider implements ServiceProviderInterface
{
    public function register(DiInterface $di) : void
    {
        $config = require_once $di->offsetGet('app_path') . '/config/config.php';
        $di->setShared('config', function () use ($config) {
            return new Config($config);
        });
    }
}