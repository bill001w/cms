<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;

class LoginController extends Admin
{
    public function indexAction(Request $request)
    {
        $url = $request->get['url'] ? urldecode($request->get('url')) : url('admin//');

        if ($request->method() === 'POST') {
            if ($request->cookie('admin_login')) {
                return $this->adminMsg(lang('a-com-25'));
            }

            $username = $request->get('username');
            $password = $request->get('password');
            $result = $this->user->check_login($request, $username, $password);

            if ($result) {
                $this->session->put('user_id', $result->uid);

                return $this->adminMsg(lang('a-com-26'), $url, 3, 1, 1);
            } else {
                if ($this->session->has('error_admin_login')) {
                    $error = (int)$this->session->get('error_admin_login') - 1;
                    if ($error <= 1) {
                        $this->session->forget('error_admin_login');
                        // 登录错误次数过多
                        set_cookie('admin_login', 1, 60 * 15);
                    } else {
                        $this->session->put('error_admin_login', $error);
                    }
                } else {
                    $error = 5;
                    $this->session->put('error_admin_login', 5);
                }

                return $this->adminMsg(lang('a-com-27', array('1' => $error)), url('admin/login') . '?url=' . $url);
            }
        }

        return $this->display('admin/login');
    }

    public function logoutAction()
    {
        if ($this->session->has('user_id')) {
            $this->session->forget('user_id');
        }

        return $this->adminMsg(lang('a-com-28'), url('admin/login'), 3, 1, 1);
    }
}