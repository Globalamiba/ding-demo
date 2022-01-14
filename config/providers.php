<?php
declare(strict_types = 1);

use Vagrant\Ding\Providers\ConfigProvider;
use Vagrant\Ding\Providers\LoggerProvider;
use Vagrant\Ding\Providers\ViewProvider;
use Vagrant\Ding\Providers\CacheProvider;

return [
    ConfigProvider::class,
    LoggerProvider::class,
    ViewProvider::class,
    CacheProvider::class
];