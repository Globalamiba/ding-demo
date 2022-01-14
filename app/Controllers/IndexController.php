<?php
declare(strict_types = 1);

namespace Vagrant\Ding\Controllers;

use Vagrant\Ding\Services\dingTalkService;

class IndexController extends BaseController
{
    public function indexAction()
    {
        if ($this->cache->has('token')) {
            $token = $this->cache->get('token');
        }
        else {
            $args = $this->config->get('ding')->toArray();
            $token = dingTalkService::main($args);
            $this->cache->set('token', $token->body->accessToken);
        }
        echo "<pre>";
        print_r($token);
        echo "</pre>";
    }
}