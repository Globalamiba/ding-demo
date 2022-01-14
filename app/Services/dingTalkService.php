<?php
declare(strict_types = 1);

namespace Vagrant\Ding\Services;

use AlibabaCloud\SDK\Dingtalk\Voauth2_1_0\Dingtalk;
use AlibabaCloud\SDK\Dingtalk\Voauth2_1_0\Models\GetAccessTokenRequest;
use Darabonba\OpenApi\Models\Config;
use \Exception;
use AlibabaCloud\Tea\Utils\Utils;
use AlibabaCloud\Tea\Exception\TeaError;

class dingTalkService
{
    public static function createClient()
    {
        $config = new Config([]);
        $config->protocol = "https";
        $config->regionId = "central";
        return new Dingtalk($config);
    }

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
}