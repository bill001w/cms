<?php

namespace App\Http\Controllers\admin;

use App\Services\Models\RoleModel;
use Illuminate\Http\Request;

class RoleController extends Admin
{
    public function __construct(Request $request)
    {
        parent::__construct($request);

        $this->role = new RoleModel();
    }

    public function indexAction()
    {
        $this->assign('list', $this->role->get_role_list());
        return $this->display('admin/auth');
    }

    public function listAction(Request $request, $roleid)
    {
        $data_file = APP_ROOT . 'Config/auth.role.ini.php';
        $data_role = require $data_file;
        $role = $data_role[$roleid];
        $data_auth = require APP_ROOT . 'Config/auth.option.ini.php';

        if ($request->method() === 'POST' && $request->get('submit')) {
            if ($roleid == 1) {
                return $this->adminMsg(lang('a-aut-1'));
            }

            $auth = array();
            foreach ($request->all() as $v => $t) {
                if (strpos($v, 'auth_') !== false && $t == 1) {
                    $auth[] = substr($v, 5);
                }
            }
            $data_role[$roleid] = $auth;

            $content = "<?php" . PHP_EOL . PHP_EOL
                . "return " . var_export($data_role, true) . ";";
            $rs = file_put_contents($data_file, $content);

            if ($rs === false) {
                return $this->adminMsg(lang('dr009') . $data_file);
            }

            return $this->adminMsg($this->getCacheCode('auth') . lang('success'), url('admin/auth/list', array('roleid' => $roleid)), 3, 1, 1);
        }

        $this->assign(array(
            'roleid' => $roleid,
            'role' => $role,
            'data' => $data_auth,
        ));
        return $this->display('admin/auth_list');
    }

    public function addAction(Request $request)
    {
        if ($request->method() === 'POST' && $request->get('submit')) {
            $rolename = $request->get('rolename');
            if (empty($rolename)) {
                return $this->adminMsg(lang('a-aut-2'));
            }
            $description = $request->get('description');

            $result = $this->role->create(['rolename' => $rolename, 'description' => $description]);

            if ($result == 1) {
                return $this->adminMsg(lang('success'), url('admin/auth'), 3, 1, 1);
            } elseif ($result == 0) {
                return $this->adminMsg(lang('a-aut-3'));
            } else {
                return $this->adminMsg(lang('a-aut-4'));
            }
        }

        return $this->display('admin/auth_add');
    }

    public function editAction(Request $request, $roleid)
    {
        if ($request->method() === 'POST' && $request->get('submit')) {
            $rolename = $request->get('rolename');
            if (empty($rolename)) {
                return $this->adminMsg(lang('a-aut-2'));
            }
            $description = $request->get('description');

            $result = $this->role
                ->where('roleid', $roleid)
                ->update([
                    'rolename' => $rolename,
                    'description' => $description
                ]);

            if ($result == 1) {
                return $this->adminMsg(lang('success'), url('admin/auth'), 3, 1, 1);
            } elseif ($result == 0) {
                return $this->adminMsg(lang('a-aut-3'));
            } else {
                return $this->adminMsg(lang('a-aut-4'));
            }
        }

        $row = $this->role->find($roleid);

        $this->assign('data', $row);
        return $this->display('admin/auth_add');
    }

    public function delAction($roleid)
    {
        if ($this->userinfo['roleid'] == $roleid) {
            return $this->adminMsg(lang('a-aut-5'));
        }
        if ($roleid == 1) {
            return $this->adminMsg(lang('a-aut-6'));
        }

        $this->role
            ->where('roleid', $roleid)
            ->delete();

        return $this->adminMsg($this->getCacheCode('auth') . lang('success'), url('admin/auth'), 3, 1, 1);
    }

    public function cacheAction($show = 0)
    {
        $roleids = array();
        $data_role = require APP_ROOT . 'Config/auth.role.ini.php';
        $role = $this->role->get_role_list();
        foreach ($role as $t) {
            $roleids[] = $t['roleid'];
        }
        foreach ($data_role as $id => $t) {
            if (!in_array($id, $roleids)) {
                unset($data_role[$id]);
            }
        }

        $content = "<?php" . PHP_EOL . PHP_EOL
            . "return " . var_export($data_role, true) . ";";
        file_put_contents(APP_ROOT . 'Config/auth.role.ini.php', $content);

        return $show ? '' : $this->adminMsg(lang('a-update'), '', 3, 1, 1);
    }
}