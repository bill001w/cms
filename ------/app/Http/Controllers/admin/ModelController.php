<?php

namespace App\Http\Controllers\admin;

use App\Servers\models\ModelModel;
use Illuminate\Http\Request;

class ModelController extends Admin
{
    private $_model;
    private $typeid;
    private $modeltype; //模型类型

    public function __construct(Request $request)
    {
        parent::__construct($request);

        $this->_model = new ModelModel();
    }

    public function indexAction()
    {
        $this->view->assign('list', $this->_model->get_data());
        $this->view->display('admin/model_list');
    }

    public function addAction(Request $request)
    {
        if ($request->method() === 'POST' && $request->get('submit')) {
            $tablename = trim($request->get('tablename'));
            if (!$tablename) {
                $this->adminMsg(lang('a-mod-1'));
            }
            if (!preg_match('/^[0-9a-z]+$/', $tablename)) {
                $this->adminMsg(lang('a-mod-2'));
            }

            $list = $request->get('listtpl') ? $request->get('listtpl') : 'list_' . $tablename . '.html';
            $show = $request->get('showtpl') ? $request->get('showtpl') : 'show_' . $tablename . '.html';
            $category = $request->get('categorytpl') ? $request->get('categorytpl') : 'category_' . $tablename . '.html';

            $tablename = 'content_' . $tablename;
            if ($this->_model->is_table_exists($tablename)) {
                $this->adminMsg(lang('a-mod-3', array('1' => $tablename)));
            }

            $data = array(
                'listtpl' => $list,
                'showtpl' => $show,
                'setting' => array2string($request->get('setting')),
                'tablename' => $tablename,
                'modelname' => $request->get('modelname'),
                'categorytpl' => $category
            );

            if ($modelid = $this->_model->set(0, $data)) {
                $this->adminMsg($this->getCacheCode('model') . lang('success'), url('admin/model/index/', array('typeid' => $this->typeid)), 3, 1, 1);
            } else {
                $this->adminMsg(lang('failure'));
            }
        }

        $this->view->assign(array(
            'rolemodel' => $this->user->get_role_list()
        ));
        $this->view->display('admin/model_add');
    }

    public function editAction(Request $request, $modelid)
    {
        if ($request->method() === 'POST' && $request->get('submit')) {
            $data = $this->_model->find($modelid);
            if (empty($data)) $this->adminMsg(lang('a-mod-4'));

            $list = $request->get('listtpl');
            $show = $request->get('showtpl');
            $setting = @array_merge(string2array($data['setting']), $request->get('setting'));
            $update = array(
                'joinid' => 0,
                'listtpl' => $list,
                'showtpl' => $show,
                'setting' => array2string($setting),
                'modelname' => $request->get('modelname'),
                'categorytpl' => $request->get('categorytpl')
            );
            $this->_model->set($modelid, $update);

            $this->adminMsg($this->getCacheCode('model') . lang('success'), url('admin/model/index/', array('typeid' => $this->typeid)), 3, 1, 1);
        }

        $data = $this->_model->find($modelid);
        $this->view->assign(array(
            'data' => $data,
            'setting' => string2array($data['setting']),
            'rolemodel' => $this->user->get_role_list()
        ));
        $this->view->display('admin/model_add');
    }

    public function delAction($modelid)
    {
        $data = $this->_model->find($modelid);
        if (!$data) $this->adminMsg(lang('a-mod-4'));
        $this->_model->del($data);
        // todo del model cache
//        $name = $this->typeid == 2 ? 'model_member' : 'model_' . $this->modeltype[$this->typeid] . '_' . $this->siteid;
//        $data = $this->cache->get($name);
//        unset($data[$mid]);
//        $this->cache->set($name, $data);
//        $all or $this->adminMsg($this->getCacheCode('model') . lang('success'), url('admin/model/index/', array('typeid' => $this->typeid)), 3, 1, 1);
    }

    public function cdisabledAction()
    {
        $modelid = (int)$this->get('modelid');
        $data = $this->_model->find($modelid);
        if (!$data) $this->adminMsg(lang('a-mod-4'));
        $setting = string2array($data['setting']);
        $setting['disable'] = $setting['disable'] == 1 ? 0 : 1;
        $this->_model->update(array('setting' => array2string($setting)), 'modelid=' . $modelid);
        $this->adminMsg($this->getCacheCode('model') . lang('success'), url('admin/model/index/', array('typeid' => $this->typeid)), 3, 1, 1);
    }

    public function exportAction()
    {
        $model = $this->typeid != 2 ? $this->get_model($this->modeltype[$this->typeid]) : $this->cache->get('model_member');
        $modelid = (int)$this->get('modelid');
        if (!$model) $this->adminMsg(lang('a-mod-4'));
        if (!isset($model[$modelid])) $this->adminMsg(lang('a-mod-4'));
        $result = array2string($model[$modelid]);
        header('Content-Disposition: attachment; filename="' . $model[$modelid]['tablename'] . '.mod"');
        echo $result;
        exit;
    }

    public function importAction()
    {
        if ($this->post('submit')) {
            $tablename = $this->post('tablename');
            if (!$tablename) $this->adminMsg(lang('a-mod-1'));
            if (!preg_match('/^[0-9a-z]+$/', $tablename)) $this->adminMsg(lang('a-mod-2'));
            $tablename = $this->typeid == 2 ? 'member_' . $tablename : $this->modeltype[$this->typeid] . '_{site}_' . $tablename;
            if ($this->_model->is_table_exists(str_replace('{site}', $this->siteid, $tablename))) {    //判断表是否存在
                $this->adminMsg(lang('a-mod-2', array('1' => str_replace('{site}', $this->siteid, $tablename))));
            }
            if (!empty($_FILES['import']['tmp_name'])) {
                $model = @file_get_contents($_FILES['import']['tmp_name']);
                if (!empty($model)) {
                    $data = string2array(trim($model));
                    if (empty($data)) $this->adminMsg(lang('a-mod-12'));
                } else {
                    $this->adminMsg(lang('a-mod-12'));
                }
            } else {
                $this->adminMsg(lang('a-mod-13'));
            }
            if ($data['typeid'] != $this->typeid) $this->adminMsg(lang('a-mod-14', array('1' => $this->modeltype[$data['typeid']])));
            $insert = array(
                'site' => $this->siteid,
                'typeid' => $this->typeid,
                'listtpl' => $data['listtpl'],
                'showtpl' => $data['showtpl'],
                'setting' => array2string($data['setting']),
                'tablename' => $tablename,
                'modelname' => $this->post('modelname'),
                'categorytpl' => $data['categorytpl']
            );
            $modelid = $this->_model->set(0, $insert);
            if (empty($modelid)) $this->adminMsg(lang('a-mod-15'));
            $field = $this->model('model_field');
            $content = $data['fields']['data']['content'];
            unset($data['fields']['data']['content']);
            if (isset($data['fields']['data']) && $data['fields']['data']) {
                foreach ($data['fields']['data'] as $t) {
                    unset($t['fieldid']);
                    $t['modelid'] = $modelid;
                    $t['setting'] = var_export($t['setting'], true);
                    if (substr($t['setting'], 0, 1) == "'") $t['setting'] = substr($t['setting'], 1);
                    if (substr($t['setting'], -1) == "'") $t['setting'] = substr($t['setting'], 0, -1);
                    $field->set(0, $t);
                }
            }
            unset($content['fieldid']);
            $content['modelid'] = $modelid;
            $content['setting'] = var_export($content['setting'], true);
            if (substr($content['setting'], 0, 1) == "'") $content['setting'] = substr($content['setting'], 1);
            if (substr($content['setting'], -1) == "'") $content['setting'] = substr($content['setting'], 0, -1);
            $field->update($content, 'modelid=' . $modelid . ' and field="content"');
            $this->adminMsg($this->getCacheCode('model') . lang('success'), url('admin/model/index/', array('typeid' => $this->typeid)), 3, 1, 1);
        }
        $this->view->display('admin/model_import');
    }

    public function cacheAction()
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
        $this->cache->set('model_content_1', $data);

        $this->adminMsg(lang('a-update'), '', 3, 1, 1);
    }
}