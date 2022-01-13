<?php
declare(strict_types = 1);

namespace Vagrant\Ding\Providers;

use Phalcon\Di\DiInterface;
use Phalcon\Di\ServiceProviderInterface;
use Phalcon\Logger;
use Phalcon\Logger\Adapter\Stream;

class LoggerProvider implements ServiceProviderInterface
{
    public function register(DiInterface $di) : void
    {
        $rootPath = $di->offsetGet('rootPath');
        $di->setShared('logger', function () use($rootPath) {
            $format = new Logger\Formatter\Line();
            $format->setDateFormat('Y-m-d H:i:s');
            $format->setFormat('[%date%] - [%type%] : %message%');

            $adapter = new Stream("{$rootPath}/storage/log/" . date('Ymd') . ".log");
            $adapter->setFormatter($format);
            return new Logger('logger', ['message' => $adapter]);
        });
    }
}