<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;

class LoginController extends Admin
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    public function indexAction(Request $request)
    {
        $url = isset($_GET['url']) && $_GET['url'] ? urldecode($request->get('url')) : url('admin//');

        if ($this->isPostForm()) {
            if ($request->cookie('admin_login')) {
                $this->adminMsg(lang('a-com-25'));
            }
            $username = $this->post('username');
            $password = $this->post('password');
            $result = $this->user->check_login($username, $password);
            if ($result) {
                $this->session->put('user_id', $result['userid']);

                $this->adminMsg(lang('a-com-26'), $url, 3, 1, 1);
            } else {
                if ($this->session->has('error_admin_login')) {
                    $error = (int)$this->session->get('error_admin_login') - 1;
                    if ($error <= 1) {
                        $this->session->forget('error_admin_login');
                        set_cookie('admin_login', 1, 60 * 15);
                    } else {
                        $this->session->put('error_admin_login', $error);
                    }
                } else {
                    $error = 5;
                    $this->session->put('error_admin_login', 5);
                }

//                $this->adminMsg(lang('a-com-27', array('1' => $error)), url('admin/login', array('url' => $this->get('url'))));
            }
        }

        $this->view->display('admin/login');
    }

    public function logoutAction()
    {
        if ($this->session->has('user_id')) {
            $this->session->forget('user_id');
        }
        $this->adminMsg(lang('a-com-28'), url('admin/login'), 3, 1, 1);
    }
}