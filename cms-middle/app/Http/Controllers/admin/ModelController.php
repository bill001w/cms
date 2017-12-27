<?php

namespace App\Http\Controllers\admin;

use App\Services\models\ModelModel;
use App\Services\Models\RoleModel;
use Illuminate\Http\Request;

class ModelController extends Admin
{
    private $_model;
    private $role;

    public function __construct(Request $request)
    {
        parent::__construct($request);

        $this->_model = new ModelModel();
        $this->role = new RoleModel();
    }

    public function indexAction()
    {
        $this->assign('list', $this->_model->get_data());
        return $this->display('admin/model_list');
    }

    public function addAction(Request $request)
    {
        if ($request->method() === 'POST' && $request->get('submit')) {
            $tablename = trim($request->get('tablename'));
            if (!$tablename) {
                return $this->adminMsg(lang('a-mod-1'));
            }
            if (!preg_match('/^[0-9a-z]+$/', $tablename)) {
                return $this->adminMsg(lang('a-mod-2'));
            }

            $list = $request->get('listtpl') ? $request->get('listtpl') : 'list_' . $tablename . '.html';
            $show = $request->get('showtpl') ? $request->get('showtpl') : 'show_' . $tablename . '.html';
            $category = $request->get('categorytpl') ? $request->get('categorytpl') : 'category_' . $tablename . '.html';

            $tablename = 'content_' . $tablename;
            if (!$this->_model->is_table_exists($tablename)) {
                return $this->adminMsg(lang('a-mod-3', array('1' => $tablename)));
            }

            $data = array(
                'listtpl' => $list,
                'showtpl' => $show,
                'setting' => array2string($request->get('setting')),
                'tablename' => $tablename,
                'categorytpl' => $category
            );

            if ($modelid = $this->_model->set(0, $data)) {
                return $this->adminMsg($this->getCacheCode('admin/model/cache') . lang('success'), url('admin/model/index/', array('typeid' => $this->typeid)), 3, 1, 1);
            } else {
                return $this->adminMsg(lang('failure'));
            }
        }

        $this->assign(array(
            'rolemodel' => $this->role->get_role_list()
        ));
        return $this->display('admin/model_add');
    }

    public function editAction(Request $request, $modelid)
    {
        if ($request->method() === 'POST' && $request->get('submit')) {
            $data = $this->_model->find($modelid);
            if (empty($data)) return $this->adminMsg(lang('a-mod-4'));

            $list = $request->get('listtpl');
            $show = $request->get('showtpl');
            $setting = @array_merge(string2array($data['setting']), $request->get('setting'));
            $update = array(
                'listtpl' => $list,
                'showtpl' => $show,
                'setting' => array2string($setting),
                'tablename' => $request->get('tablename'),
                'categorytpl' => $request->get('categorytpl')
            );
            $this->_model->set($modelid, $update);

            return $this->adminMsg($this->getCacheCode('admin/model/cache') . lang('success'), url('admin/model/index/', array('typeid' => $this->typeid)), 3, 1, 1);
        }

        $data = $this->_model->find($modelid);
        $this->assign(array(
            'data' => $data,
            'setting' => string2array($data['setting']),
            'rolemodel' => $this->role->get_role_list()
        ));
        return $this->display('admin/model_add');
    }

    public function delAction($modelid)
    {
        $data = $this->_model->find($modelid);
        if (!$data) return $this->adminMsg(lang('a-mod-4'));

        $this->_model->del($data);

        return $this->adminMsg($this->getCacheCode('admin/model/cache') . lang('success'), url('admin/model/index/', array('typeid' => $this->typeid)), 3, 1, 1);
    }

    public function cacheAction($show = 0)
    {
        $this->delDir($this->_model->cache_dir);
        if (!file_exists($this->_model->cache_dir)) @mkdir($this->_model->cache_dir, 0777, true);

        $model = $this->_model->get_data();
        $data = array();
        foreach ($model as $t) {
            $setting = string2array($t['setting']);
            if ($setting['disable'] == 1) continue;
            $id = $t['modelid'];
            $data[$id] = $t;
            $data[$id]['setting'] = $setting;
        }
        $this->cache->set('model', $data);

        return $show ? '' : $this->adminMsg(lang('a-update'), '', 3, 1, 1);
    }
}