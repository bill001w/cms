<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Common;
use Illuminate\Http\Request;

class IndexController extends Common
{
    public function indexAction(Request $request)
    {
        $this->assign(array(
            'indexc' => 1, //首页标识符
            'meta_title' => $this->site['SITE_TITLE'],
            'meta_keywords' => $this->site['SITE_KEYWORDS'],
            'meta_description' => $this->site['SITE_DESCRIPTION'],
        ));
dd(1);
        $this->display('front/index1');
    }
}