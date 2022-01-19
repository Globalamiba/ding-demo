<?php
declare(strict_types = 1);

namespace Vagrant\Ding\Services;

use AlibabaCloud\SDK\Dingtalk\Voauth2_1_0\Dingtalk;
use AlibabaCloud\SDK\Dingtalk\Voauth2_1_0\Models\GetAccessTokenRequest;
use Darabonba\OpenApi\Models\Config;
use \Exception;
use AlibabaCloud\Tea\Utils\Utils;
use AlibabaCloud\Tea\Utils\Utils\RuntimeOptions;
use AlibabaCloud\Tea\Exception\TeaError;

//获取部门和用户信息  旧SDK
use DingTalkClient;
use DingTalkConstant;
use OapiV2DepartmentListsubRequest;
use OapiV2UserListRequest;

//发送通知 旧SDK
use OA;
use OapiMessageCorpconversationAsyncsendV2Request;
use Msg;
use Text;
use Body;

//创建代办
use AlibabaCloud\SDK\Dingtalk\Vtodo_1_0\Dingtalk as Dingtalk_v1;
use AlibabaCloud\SDK\Dingtalk\Vtodo_1_0\Models\CreateTodoTaskHeaders;
use AlibabaCloud\SDK\Dingtalk\Vtodo_1_0\Models\CreateTodoTaskRequest;
use AlibabaCloud\SDK\Dingtalk\Vtodo_1_0\Models\CreateTodoTaskRequest\notifyConfigs;

//获取用户token 扫码登录
use AlibabaCloud\SDK\Dingtalk\Voauth2_1_0\Models\GetUserTokenRequest;
use AlibabaCloud\SDK\Dingtalk\Vcontact_1_0\Models\GetUserHeaders;
use AlibabaCloud\SDK\Dingtalk\Vcontact_1_0\Dingtalk as contact_dingtalk;

class dingTalkService
{
    public static function createClient()
    {
        $config = new Config([]);
        $config->protocol = "https";
        $config->regionId = "central";
        return new Dingtalk($config);
    }

    //获取企业内部应用access token
    public static function main($args)
    {
        $client = self::createClient();
        $getAccessTokenRequest = new GetAccessTokenRequest([
            "appKey" => $args['AppKey'],
            "appSecret" => $args['AppSecret']
        ]);
        try {
            return $client->getAccessToken($getAccessTokenRequest);
        }
        catch (Exception $err) {
            if (!($err instanceof TeaError)) {
                $err = new TeaError([], $err->getMessage(), $err->getCode(), $err);
            }
            if (!Utils::empty_($err->code) && !Utils::empty_($err->message)) {
                // err 中含有 code 和 message 属性，可帮助开发定位问题
            }
        }
    }

    //获取下级部门列表
    public function testOldSDK(string $access_token, int $dept_id)
    {
        $c = new DingTalkClient(DingTalkConstant::$CALL_TYPE_OAPI, DingTalkConstant::$METHOD_POST , DingTalkConstant::$FORMAT_JSON);
        $req = new OapiV2DepartmentListsubRequest;
        $req->setDeptId($dept_id);
        $resp = $c->execute($req, $access_token, "https://oapi.dingtalk.com/topapi/v2/department/listsub");
        return $resp;
    }

    static function getDepartmentUsers(string $access_token, int $cursor = 0,int $dept_id = 1) : object
    {
        $c = new DingTalkClient(DingTalkConstant::$CALL_TYPE_OAPI, DingTalkConstant::$METHOD_POST , DingTalkConstant::$FORMAT_JSON);
        $req = new OapiV2UserListRequest;
        $req->setDeptId($dept_id);
        $req->setCursor($cursor);
        $req->setSize(20);
        return $c->execute($req, $access_token, "https://oapi.dingtalk.com/topapi/v2/user/list");
    }

    static function createTodoTask(string $access_token, string $union_id, string $subject)
    {
        $config = new Config([]);
        $config->protocol = "https";
        $config->regionId = "central";
        $client = new Dingtalk_v1($config);
        $createTodoTaskHeaders = new CreateTodoTaskHeaders([]);
        $createTodoTaskHeaders->xAcsDingtalkAccessToken = $access_token;
        $notifyConfigs = new notifyConfigs([
            "dingNotify" => "1"
        ]);
        $createTodoTaskRequest = new CreateTodoTaskRequest([
            'unionId' => $union_id,
            'subject' => $subject,
            'notifyConfigs' => $notifyConfigs
        ]);
        try {
            return $client->createTodoTaskWithOptions($union_id, $createTodoTaskRequest, $createTodoTaskHeaders, new RuntimeOptions([]));
        }
        catch (Exception $err) {
            if (!($err instanceof TeaError)) {
                $err = new TeaError([], $err->getMessage(), $err->getCode(), $err);
            }
            if (!Utils::empty_($err->code) && !Utils::empty_($err->message)) {
                // err 中含有 code 和 message 属性，可帮助开发定位问题
            }
        }
    }

    static function sendNotify(string $access_token, string $agent_id, string $userid_list, array $message)
    {
        $c = new DingTalkClient(DingTalkConstant::$CALL_TYPE_OAPI, DingTalkConstant::$METHOD_POST , DingTalkConstant::$FORMAT_JSON);
        $req = new OapiMessageCorpconversationAsyncsendV2Request;
        $req->setAgentId($agent_id);
        $req->setUseridList($userid_list);
        $msg = new Msg;
        $msg->msgtype=$message['type'];
        $text = new Text;
        $text->content=$message['content'];
        $msg->text = $text;
        $oa = new OA;
        $body = new Body;
        $body->content=$message['content'];
        $oa->body = $body;
        $msg->oa = $oa;
        $req->setMsg($msg);
        return $c->execute($req, $access_token, "https://oapi.dingtalk.com/topapi/message/corpconversation/asyncsend_v2");
    }

    static function getUserToken(string $code, string $client_id, string $client_secret)
    {
        $client = self::createClient();
        $getUserTokenRequest = new GetUserTokenRequest([
            "clientId" => $client_id,
            "clientSecret" => $client_secret,
            "code" => $code,
            //"refreshToken" => "abcd",
            "grantType" => "authorization_code"   //authorization_code：获取token;  refresh_token:刷新token (需要带refreshToken参数)
        ]);
        try {
            return $client->getUserToken($getUserTokenRequest);
        }
        catch (Exception $err) {
            if (!($err instanceof TeaError)) {
                $err = new TeaError([], $err->getMessage(), $err->getCode(), $err);
            }
            if (!Utils::empty_($err->code) && !Utils::empty_($err->message)) {
                // err 中含有 code 和 message 属性，可帮助开发定位问题
            }
        }
    }

    static function getUserInfoWithToken(string $token)
    {
        $config = new Config([]);
        $config->protocol = "https";
        $config->regionId = "central";
        $client = new contact_dingtalk($config);
        $getUserHeaders = new GetUserHeaders([]);
        $getUserHeaders->xAcsDingtalkAccessToken = $token;
        try {
            return $client->getUserWithOptions("me", $getUserHeaders, new RuntimeOptions([]));
        }
        catch (Exception $err) {
            if (!($err instanceof TeaError)) {
                $err = new TeaError([], $err->getMessage(), $err->getCode(), $err);
            }
            if (!Utils::empty_($err->code) && !Utils::empty_($err->message)) {
                // err 中含有 code 和 message 属性，可帮助开发定位问题
            }
        }
    }

}