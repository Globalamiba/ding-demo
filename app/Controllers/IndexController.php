<?php
declare(strict_types = 1);

namespace Vagrant\Ding\Controllers;

use Vagrant\Ding\Services\dingTalkService;

class IndexController extends BaseController
{
    public function indexAction()
    {
        if (!$this->cache->has('userinfo')) {
            $params = [
                'redirect_uri' => urlencode('http://183.136.151.130:8080/Auth'),
                'response_type' => 'code',
                'client_id' => $this->config->path('ding.AppKey'),
                'scope' => 'openid',
                'state' => 'test',
                'prompt' => 'consent'
            ];
            $str = http_build_query($params);
            $url = 'https://login.dingtalk.com/oauth2/auth?'.$str;
            $this->logger->info("has info redirect:".$url);
            $this->response->redirect($url);
        }
        $this->assets->addJs('https://g.alicdn.com/dingding/dingtalk-jsapi/2.13.42/dingtalk.open.js', false);
        $this->assets->addJs('https://code.jquery.com/jquery-3.6.0.min.js', false);
        $this->assets->addCss('https://unpkg.com/element-plus/dist/index.css', false);
        $this->assets->addCss('https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css', false);
        $this->assets->addJs('https://unpkg.com/vue@next', false);
        $this->assets->addJs('https://unpkg.com/element-plus', false);

        $dept_id = $this->request->get('dept_id') ?? 1;
        $access_token = $this->getToken();
        $department = (new dingTalkService)->testOldSDK($access_token, (int)$dept_id);

        foreach($department->result as $v) {
            $dept[] = ['id' => $v->dept_id, 'name' => $v->name];
        }
        $dept = $dept ?? [];
        $this->view->setVar('department', $dept);
    }

    public function testAction()
    {
        $params = [
            'redirect_url' => urlencode('http://183.136.151.130:8080/Auth'),
            'response_type' => 'code',
            'client_id' => $this->config->path('ding.AppKey'),
            'scope' => 'openid',
            'state' => 'test',
            'prompt' => 'consent'
        ];
        $a = http_build_query($params);
        $url = 'https://login.dingtalk.com/oauth2/auth?';
        var_dump($url.$a);
    }

    public function getNextDepartmentAction()
    {
        $dept_id = $this->request->get('dept_id') ?? 1;
        $access_token = $this->getToken();
        $department = (new dingTalkService)->testOldSDK($access_token, (int)$dept_id);
        foreach($department->result as $v) {
            $dept[] = ['id' => $v->dept_id, 'name' => $v->name];
        }
        $dept = $dept ?? [];
        echo json_encode($dept);
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

    public function getDepartmentUsersAction()
    {
        $dept_id = $this->request->get('dept_id') ?? 1;
        $token = $this->getToken();
        $users = dingTalkService::getDepartmentUsers($token, 0, (int)$dept_id);
        $result = [];
        if (isset($users->result->list) && !empty($users->result->list)) {
            foreach ($users->result->list as $v) {
                $result[] = ['userid' => $v->userid, 'name' => $v->name, 'title' => $v->title ?? '', 'unionid' => $v->unionid, 'avatar' => $v->avatar ?? ''];
            }
        }
        echo json_encode($result);
    }

    public function createTodoTaskAction()
    {
        $union_id = $this->request->get('union_id', '', 'INbJzOoOlliiaOHNsViikwPAiEiE');
        $subject = $this->request->get('subject');
        if ($union_id !== 'INbJzOoOlliiaOHNsViikwPAiEiE') $union_id = 'INbJzOoOlliiaOHNsViikwPAiEiE';
        $result = dingTalkService::createTodoTask($this->getToken(), $union_id, $subject);
        $this->logger->info("createTodoTask:".json_encode($result));
        echo json_encode($result);
    }

    public function sendNotifyAction()
    {
        $userid = $this->request->get('userid', '', '0137341258938480');
        $content = $this->request->get('content');
        if ($userid !== '0137341258938480') $userid = '0137341258938480';
        $re = dingTalkService::sendNotify($this->getToken(), $this->config->path('ding.AgentId'), $userid, ['type' => 'text', 'content' => $content]);
        if($re->errcode === 0) {
            echo "success";
        }
        else {
            $this->logger->info('send notify error:'.json_encode($re));
            echo "fail";
        }
    }
}