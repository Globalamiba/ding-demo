<?php
declare(strict_types = 1);

namespace Vagrant\Ding\Controllers;

use Vagrant\Ding\Services\dingTalkService;

class AuthController extends BaseController
{
    public function indexAction()
    {
        $code = $this->request->get('authCode');
        $this->logger->info("url:".$_SERVER['SERVER_NAME'].':'.$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"]);
        $this->logger->info("dingding code:".$code);
        $token = dingTalkService::getUserToken($code, $this->config->path('ding.AppKey'), $this->config->path('ding.AppSecret'));
        $this->logger->info("user token:".json_encode($token));
        $this->cache->set('user_token', $token->accessToken);
        $userinfo = dingTalkService::getUserInfoWithToken($token->accessToken);
        $this->logger->info("user token:".json_encode($userinfo));
        $this->cache->set('userInfo', $userinfo);
        $this->response->redirect('/index/index');
    }
}