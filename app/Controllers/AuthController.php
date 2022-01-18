<?php
declare(strict_types = 1);

namespace Vagrant\Ding\Controllers;

use Vagrant\Ding\Services\dingTalkService;

class AuthController extends BaseController
{
    public function indexAction()
    {
        $code = $this->request->get('authCode');
        $token = dingTalkService::getUserToken($code, $this->config->path('ding.AppKey'), $this->config->path('ding.AppSecret'));
        $this->cache->set('user_token', $token->accessToken);
        $userinfo = dingTalkService::getUserInfoWithToken($token->accessToken);
        $this->cache->set('userInfo', $userinfo);
        $this->response->redirect('/index/index');
    }
}