<?php

namespace App\Http\Controllers\admin;

use App\Services\Models\RoleModel;
use Illuminate\Http\Request;

class UserController extends Admin
{
    public function indexAction(Request $request)
    {
        $roleid = $request->get('roleid');
        $data = $this->user->get_user_list($roleid, 1);

        $this->assign('list', $data);
        return $this->display('admin/user_list');
    }

    public function addAction(Request $request)
    {
        $roleModel = new RoleModel();
        $role = $roleModel->get_role_list();

        if ($request->method() === 'POST' && $request->get('submit')) {
            $username = $request->get('username');
            if (!$username) return $this->adminMsg(lang('a-use-0'));
            if ($this->user->where('username', $username)->first()) return $this->adminMsg(lang('a-use-2'));

            $data = array(
                'username' => $username,
                'realname' => $request->get('realname'),
                'email' => $request->get('email'),
                'roleid' => $request->get('roleid'),
            );
            $data['salt'] = substr(md5(time()), 0, 10);
            $data['password'] = md5(md5($request->get('password')) . $data['salt'] . md5($request->get('password')));

            $this->user->insert($data);

            return $this->adminMsg(lang('success'), url('admin/user/index/'), 3, 1, 1);
        }

        $this->assign('role', $role);
        $this->assign('pwd', '');
        return $this->display('admin/user_add');
    }

    public function editAction(Request $request, $uid)
    {
        $roleModel = new RoleModel();
        $role = $roleModel->get_role_list();

        if ($request->method() === 'POST' && $request->get('submit')) {
            $username = $request->get('username');
            if (!$username) return $this->adminMsg(lang('a-use-0'));
            if (!$user = $this->user->find($uid)) return $this->adminMsg(lang('a-use-3'));

            $data = array(
                'realname' => $request->get('realname'),
                'email' => $request->get('email'),
                'roleid' => $request->get('roleid'),
            );
            if ($request->get('password')) $data['password'] = md5(md5($request->get('password')) . $user['salt'] . md5($request->get('password')));
            $this->user->where('uid', $uid)->update($data);

            return $this->adminMsg(lang('success'), url('admin/user/index/'), 3, 1, 1);
        }

        $user = $this->user->find($uid);
        if (empty($user)) return $this->adminMsg(lang('a-use-3'));

        $this->assign(array(
            'data' => $user,
            'role' => $role,
            'menu' => string2array($user['usermenu']),
        ));
        return $this->display('admin/user_add');
    }

    public function ajaxeditAction(Request $request)
    {
        $user = $this->userinfo;
        $uid = $user['uid'];

        if ($request->method() === 'POST' && $request->get('submit')) {
            $data = array(
                'realname' => $request->get('realname'),
                'email' => $request->get('email'),
            );
            if ($request->get('password')) $data['password'] = md5(md5($request->get('password')) . $user['salt'] . md5($request->get('password')));

            $this->user->where('uid', $uid)->update($data);

            return $this->adminMsg(lang('success'), url('admin/user/ajaxedit/'), 3, 1, 1);
        }

        if (empty($user)) return $this->adminMsg(lang('a-use-3'));

        $this->assign(array(
            'data' => $user,
        ));
        return $this->display('admin/user_edit');
    }

    public function delAction($uid)
    {
        if ($this->userinfo['uid'] == $uid) return $this->adminMsg(lang('a-use-4'));

        $this->user->where('uid', $uid)->delete();

        return $this->adminMsg(lang('success'), url('admin/user/index/'), 3, 1, 1);
    }
}