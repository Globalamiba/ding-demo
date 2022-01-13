<?php
declare(strict_types = 1);

namespace Vagrant\Ding;

use Phalcon\Mvc\Application;
use Phalcon\Di\FactoryDefault as Di;

class Bootstrap
{
    private string $app_path;
    private Di $di;
    public function __construct(string $app_path)
    {
        $this->app_path = $app_path;
        $this->di = new Di;
        $this->di->offsetSet('app_path', $app_path);
    }

    public function run() : void
    {
        $this->initializationProviders();
        $this->di->getShared('dispatcher')->setDefaultNamespace('Vagrant\Ding\Controller');
        (new Application($this->di))->handle($_SERVER['REQUEST_URI'])->send();
    }

    private function initializationProviders() : void
    {
        $providers = require_once $this->app_path . '/config/providers.php';
        foreach ($providers as $provider) {
            (new $provider)->register($this->di);
        }
    }
}