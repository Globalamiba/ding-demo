<?php
declare(strict_types = 1);

namespace Vagrant\Ding\Controllers;

use Vagrant\Ding\Services\dingTalkService;

class IndexController extends BaseController
{
    public function indexAction()
    {
        $this->assets->addJs('https://g.alicdn.com/dingding/dingtalk-jsapi/2.13.42/dingtalk.open.js', false);
        $this->assets->addJs('https://unpkg.com/vue@next', false);

        $this->view->setVar('id', $this->config->path('ding.corpId'));
    }

    public function testAction()
    {
        //var_dump($this->config->path("ding.corpId"));
    }

    private function getToken() : string
    {
        if ($this->cache->has('token')) {
            $token = $this->cache->get('token');
        }
        else {
            $args = $this->config->get('ding')->toArray();
            $accessToken = dingTalkService::main($args);
            $this->cache->set('token', $accessToken->body->accessToken);
            $token = $accessToken->body->accessToken;
        }
        return $token;
    }

    public function getUserAction()
    {
        $code = $this->request->get('code');
        $token = $this->getToken();

        $userId = dingTalkService::getUserId($code, $token);
        var_dump($code);
        var_dump($userId);
    }
}