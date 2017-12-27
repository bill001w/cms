<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;

class PositionController extends Admin
{
    protected $position;
    protected $position_data;

    public function __construct(Request $request)
    {
        parent::__construct($request);

        $this->position = $this->model('position');
        $this->position_data = $this->model('position_data');
    }

    public function indexAction(Request $request)
    {
        if ($request->method() === 'POST' && $request->get('submit')) {
            foreach ($request->all() as $var => $value) {
                if (strpos($var, 'del_') !== false) {
                    $id = (int)str_replace('del_', '', $var);
                    $this->position->del($id);
                }
            }

            $this->adminMsg($this->getCacheCode('position') . lang('success'), url('admin/position/index'), 3, 1, 1);
        }

        $data = $this->position->where('site=' . $this->siteid)->select();
        $this->view->assign('list', $data);
        $this->view->display('admin/position_list');
    }

    public function addAction(Request $request)
    {
        if ($request->method() === 'POST' && $request->get('submit')) {
            $data = $request->get('data');
            if (empty($data['name'])) $this->adminMsg(lang('a-pos-10'));

            $data['maxnum'] = $data['maxnum'] ? $data['maxnum'] : 10;

            if ($this->position->set(0, $data)) {
                $this->adminMsg($this->getCacheCode('position') . lang('success'), url('admin/position/index'), 3, 1, 1);
            } else {
                $this->adminMsg(lang('failure'));
            }
        }

        $this->view->display('admin/position_add');
    }

    public function editAction(Request $request, $posid)
    {
        if (empty($posid)) $this->adminMsg(lang('a-pos-11'));

        if ($request->method() === 'POST' && $request->get('submit')) {
            $data = $request->get('data');
            if (empty($data['name'])) $this->adminMsg(lang('a-pos-10'));
            $data['maxnum'] = $data['maxnum'] ? $data['maxnum'] : 10;

            $this->position->set($posid, $data);
            $this->adminMsg($this->getCacheCode('position') . lang('success'), url('admin/position/index'), 3, 1, 1);
        }

        $data = $this->position->find($posid);
        if (empty($data)) $this->adminMsg(lang('a-pos-11'));

        $this->view->assign('data', $data);
        $this->view->display('admin/position_add');
    }

    public function delAction($posid)
    {
        if (empty($posid)) $this->adminMsg(lang('a-pos-11'));

        $this->position->del($posid);

        $this->adminMsg($this->getCacheCode('position') . lang('success'), url('admin/position/index'), 3, 1, 1);
    }

    public function listAction(Request $request, $posid)
    {
        if (empty($posid)) $this->adminMsg(lang('a-pos-11'));

        if ($request->method() === 'POST' && $request->get('submit_order') && $request->get('form') == 'order') {
            foreach ($request->all() as $var => $value) {
                if (strpos($var, 'order_') !== false) {
                    $id = (int)str_replace('order_', '', $var);
                    $this->position_data->update(array('listorder' => $value), 'id=' . $id);
                }
            }

            $this->adminMsg($this->getCacheCode('position') . lang('success'), url('admin/position/list/', array('posid' => $posid)), 3, 1, 1);
        }

        if ($request->method() === 'POST' && $request->get('submit_del') && $request->get('form') == 'del') {
            foreach ($request->all() as $var => $value) {
                if (strpos($var, 'del_') !== false) {
                    $id = (int)str_replace('del_', '', $var);
                    $data = $this->position_data->find($id, 'contentid');
                    if ($data['contentid']) { //判断该推荐信息是否来至文档内容
                        $cdata = $this->content->get_extend_data($data['contentid']);
                        if ($cdata['position']) {
                            $cp = @explode(',', $cdata['position']);
                            $pn = array();
                            foreach ($cp as $t) {
                                if ($t != $posid) $pn[] = $t;
                            }
                            $pn = @implode(',', $pn);
                            $cdata['position'] = $pn;
                            $this->content->set_extend_data($data['contentid'], $cdata); //删除文档中的推荐位信息
                        }
                    }

                    $this->position_data->delete('id=' . $id);
                }
            }

            $this->adminMsg($this->getCacheCode('position') . lang('success'), url('admin/position/list/', array('posid' => $posid)), 3, 1, 1);
        }

        $this->view->assign(array(
            'posid' => $posid,
            'list' => $this->position_data->where('posid=' . $posid)->order('listorder ASC')->select(),
        ));
        $this->view->display('admin/position_data_list');
    }

    public function adddataAction(Request $request, $posid)
    {
        if (empty($posid)) $this->adminMsg(lang('a-pos-11'));
        if ($request->method() === 'POST' && $request->get('submit')) {
            $data = $request->get('data');
            if (empty($data['title']) || empty($data['url'])) $this->adminMsg(lang('a-pos-12'));
            $data['posid'] = $posid;

            if ($this->position_data->set(0, $data)) {
                $this->adminMsg($this->getCacheCode('position') . lang('success'), url('admin/position/list/', array('posid' => $posid)), 3, 1, 1);
            } else {
                $this->adminMsg(lang('a-pos-13'));
            }
        }

        $position = $this->position->find($posid);
        if (empty($position)) $this->adminMsg(lang('a-pos-11'));

        $this->view->assign(array(
            'posid' => $posid,
            'position' => $position
        ));
        $this->view->display('admin/position_data_add');
    }

    public function editdataAction(Request $request, $posid, $id)
    {
        if (empty($posid)) $this->adminMsg(lang('a-pos-11'));

        if ($request->method() === 'POST' && $request->get('submit')) {
            $data = $request->get('data');
            if (empty($data['title']) || empty($data['url'])) $this->adminMsg(lang('a-pos-12'));
            $data['posid'] = $posid;

            if ($this->position_data->set($id, $data)) {
                $this->adminMsg($this->getCacheCode('position') . lang('success'), url('admin/position/list/', array('posid' => $posid)), 3, 1, 1);
            } else {
                $this->adminMsg(lang('a-pos-13'));
            }
        }

        $position = $this->position->find($posid);
        if (empty($position)) $this->adminMsg(lang('a-pos-11'));
        $data = $this->position_data->find($id);
        if (empty($data)) $this->adminMsg(lang('a-pos-14'));

        $this->view->assign(array(
            'data' => $data,
            'posid' => $posid,
            'position' => $position,
        ));
        $this->view->display('admin/position_data_add');
    }

    public function cacheAction($show = 0, $site_id = 0)
    {
        $data = array();
        $position = $this->position->select();
        foreach ($position as $t) {
            $posid = $t['posid'];
            $data[$posid] = $this->position_data->where('posid=' . $posid)->order('listorder ASC, id DESC')->select();
            if ($data[$posid]) {
                foreach ($data[$posid] as $id => $c) {
                    if ($c['contentid']) {
                        $row = $this->content->find($c['contentid']);
                        if ($row && $row['url'] != $c['url']) {
                            $data[$posid][$id]['url'] = $row['url'];
                            $this->position_data->update(array('url' => $row['url']), 'id=' . $c['id']);
                        }
                    }
                }
            }

            $data[$posid]['maxnum'] = $t['maxnum'];
            $data[$posid]['catid'] = $t['catid'];
        }

        $this->cache->set('position_1', $data);
        $show or $this->adminMsg(lang('a-update'), '', 3, 1, 1);
    }

    /**
     * 加载模板调用代码
     */
    public function ajaxviewAction(Request $request)
    {
        $posid = (int)$this->get('posid');
        $data = $this->position->find($posid);
        if (empty($data)) exit(lang('a-pos-12'));
        $param = empty($data['catid']) ? $posid : $posid . ' catid=$catid';
        $msg = "<textarea id='position_" . $posid . "' style='font-size:12px;width:100%;height:80px;overflow:hidden;'>";
        $msg .= '<!-- ' . $data['name'] . ' -->' . PHP_EOL;
        $msg .= '{list action=position id=' . $param . '}' . PHP_EOL;
        $msg .= '<!-- ' . lang('a-pos-15') . ' -->' . PHP_EOL;
        $msg .= '{/list}';
        $msg .= '</textarea>';
        echo $msg;
    }

    /**
     * 加载内容表中的信息
     */
    public function ajaxloadinfoAction(Request $request)
    {
        $select = $this->content->order('updatetime DESC')->limit(0, 20);
        $title = $request->method() === 'POST' && $request->get('title');
        $catid = $request->method() === 'POST' && $request->get('catid');
        $thumb = $request->method() === 'POST' && $request->get('thumb');
        $select->where('`status`=1');
        if ($catid && $this->cats[$catid]['arrchilds']) $select->where('catid IN (' . $this->cats[$catid]['arrchilds'] . ')');
        if ($title) $select->where('title like "%' . $title . '%"');
        if ($thumb) $select->where('thumb<>""');
        $list = $select->select();
        $tree = $this->instance('tree');
        $tree->config(array('id' => 'catid', 'parent_id' => 'parentid', 'name' => 'catname'));
        $option = $tree->get_tree($this->cats, 0, null, '&nbsp;|-', 0);
        $this->view->assign(array(
            'list' => $list,
            'category' => $option
        ));
        $this->view->display('admin/position_data_load');
    }
}