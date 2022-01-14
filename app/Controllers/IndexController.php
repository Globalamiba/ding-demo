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
        /*$code = $this->request->get('code');
        $token = $this->getToken();

        $userId = dingTalkService::getUserId($code, $token);
        var_dump($code);
        var_dump($userId);*/
    }

    public function getDepartmentUsersAction()
    {
        /*$token = $this->getToken();
        $department = dingTalkService::getDepartmentUsers($token);
        $level_one = json_decode($department, true);

        foreach ($level_one['result']['list'] as $v) {
            if (is_array($v['dept_id_list']) && count($v['dept_id_list']) > 1) {
                foreach ($v['dept_id_list'] as $dept_id) {
                    if (strlen((string)$dept_id) <= 1) continue;
                    $level_two = dingTalkService::getDepartmentUsers($token, 0, $dept_id);
                    $this->format(json_decode($level_two, true)['result']['list']);
                    unset($level_two);
                }
            }
        }*/
    }

    private function format($member)
    {
        echo "<pre>";
        foreach ($member as $v) {
            echo "name:".$v['name']."<br>";
            echo "title:".$v['title']."<br>";
            echo "userid:".$v['userid']."<br>";
            echo "avatar:<img width='30px' height='30px' src='".$v['avatar']."' /><br><br>";
        }
        echo "</pre>";
    }
}