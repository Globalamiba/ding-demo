<?php
declare(strict_types = 1);

namespace Vagrant\Ding\Providers;

use Phalcon\Di\DiInterface;
use Phalcon\Di\ServiceProviderInterface;
use Phalcon\Cache;
use Phalcon\Storage\SerializerFactory;
use Phalcon\Cache\Adapter\Stream;

class CacheProvider implements ServiceProviderInterface
{
    public function register(DiInterface $di) : void
    {
        $di->setShared('cache', function () {
            $adapter = new Stream(new SerializerFactory(), ['defaultSerializer' => 'Json', 'lifetime' => 7200, 'storageDir' => $this->offsetGet('app_path') . '/storage/cache']);
            return new Cache($adapter);
        });
    }
}