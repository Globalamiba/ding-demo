<?php
declare(strict_types = 1);

namespace Vagrant\Ding\Providers;

use Phalcon\Di\DiInterface;
use Phalcon\Di\ServiceProviderInterface;
use Phalcon\Cache;
use Phalcon\Cache\AdapterFactory;
use Phalcon\Storage\SerializerFactory;

class CacheProvider implements ServiceProviderInterface
{
    public function register(DiInterface $di) : void
    {
        $di->setShared('cache', function () {
            $adapter = new AdapterFactory(new SerializerFactory());
            return new Cache($adapter->newInstance("apcu", ['defaultSerializer' => 'Json', 'lifetime' => 7200]));
        });
    }
}