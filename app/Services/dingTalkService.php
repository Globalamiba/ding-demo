<?php
declare(strict_types = 1);

namespace Vagrant\Ding\Services;

use AlibabaCloud\SDK\Dingtalk\Voauth2_1_0\Dingtalk;
use AlibabaCloud\SDK\Dingtalk\Voauth2_1_0\Models\GetAccessTokenRequest;
use Phalcon\Mvc\Controller;

class dingTalkService extends Controller
{
    public function test()
    {
        $config = $this->config;
        var_dump($config);
    }
}