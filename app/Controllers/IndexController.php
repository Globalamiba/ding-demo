<?php
declare(strict_types = 1);

namespace Vagrant\Ding\Controllers;

use Vagrant\Ding\Services\dingTalkService;

class IndexController extends BaseController
{
    public function indexAction()
    {
        $args = $this->config->get('ding')->toArray();
        $token = dingTalkService::main($args);
        echo "<pre>";
        print_r($token);
        echo "</pre>";
    }
}