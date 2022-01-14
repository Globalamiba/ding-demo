<?php
declare(strict_types = 1);

namespace Vagrant\Ding\Controllers;

use Vagrant\ding\Services\dingTalkService;

class IndexController extends BaseController
{
    public function indexAction()
    {
        $ding = new dingTalkService();
        $ding->test();
    }
}