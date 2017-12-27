<?php

namespace App\Http\Controllers\front;

use Illuminate\Http\Request;

class IndexController extends FrontController
{
    public function indexAction(Request $request)
    {
        $this->assign(array(
            'indexc' => 1, //首页标识符
            'meta_title' => $this->site['SITE_TITLE'],
            'meta_keywords' => $this->site['SITE_KEYWORDS'],
            'meta_description' => $this->site['SITE_DESCRIPTION'],
        ));

        return $this->display('front/index');
    }
}