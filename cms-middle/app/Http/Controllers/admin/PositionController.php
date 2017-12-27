<?php

namespace App\Http\Controllers\admin;

use App\Services\dayrui\libraries\tree;
use App\Services\Models\PositionDataModel;
use App\Services\Models\PositionModel;
use Illuminate\Http\Request;

class PositionController extends Admin
{
    protected $position;
    protected $position_data;

    public function __construct(Request $request)
    {
        parent::__construct($request);

        $this->position = new PositionModel();
        $this->position_data = new PositionDataModel();
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

            return $this->adminMsg($this->getCacheCode('admin/position/cache') . lang('success'), url('admin/position/index'), 3, 1, 1);
        }

        $data = $this->position->all()->toArray();
        $this->assign('list', $data);
        return $this->display('admin/position_list');
    }

    public function addAction(Request $request)
    {
        if ($request->method() === 'POST' && $request->get('submit')) {
            $data = $request->get('data');
            if (empty($data['name'])) return $this->adminMsg(lang('a-pos-10'));

            $data['maxnum'] = $data['maxnum'] ? $data['maxnum'] : 10;

            if ($this->position->set(0, $data)) {
                return $this->adminMsg($this->getCacheCode('admin/position/cache') . lang('success'), url('admin/position/index'), 3, 1, 1);
            } else {
                return $this->adminMsg(lang('failure'));
            }
        }

        return $this->display('admin/position_add');
    }

    public function editAction(Request $request, $posid)
    {
        if (empty($posid)) return $this->adminMsg(lang('a-pos-11'));

        if ($request->method() === 'POST' && $request->get('submit')) {
            $data = $request->get('data');
            if (empty($data['name'])) return $this->adminMsg(lang('a-pos-10'));
            $data['maxnum'] = $data['maxnum'] ? $data['maxnum'] : 10;

            $this->position->set($posid, $data);
            return $this->adminMsg($this->getCacheCode('admin/position/cache') . lang('success'), url('admin/position/index'), 3, 1, 1);
        }

        $data = $this->position->find($posid);
        if (empty($data)) return $this->adminMsg(lang('a-pos-11'));

        $this->assign('data', $data);
        return $this->display('admin/position_add');
    }

    public function delAction($posid)
    {
        if (empty($posid)) return $this->adminMsg(lang('a-pos-11'));

        $this->position->del($posid);

        return $this->adminMsg($this->getCacheCode('admin/position/cache') . lang('success'), url('admin/position/index'), 3, 1, 1);
    }

    // 信息管理
    public function listAction(Request $request, $posid)
    {
        if (empty($posid)) return $this->adminMsg(lang('a-pos-11'));

        if ($request->method() === 'POST' && $request->get('submit_order')) {
            dd($request->all());
            foreach ($request->all() as $var => $value) {
                if (strpos($var, 'order_') !== false) {
                    $id = (int)str_replace('order_', '', $var);
                    $this->position_data->where('id', $id)
                        ->update(array('listorder', $value));
                }
            }

            return $this->adminMsg($this->getCacheCode('admin/position/cache') . lang('success'), url('admin/position/list/', array('posid' => $posid)), 3, 1, 1);
        }

        if ($request->method() === 'POST' && $request->get('submit_del')) {
            foreach ($request->all() as $var => $value) {
                if (strpos($var, 'del_') !== false) {
                    $id = (int)str_replace('del_', '', $var);

                    // 删除文档中的推荐位信息
                    $data = $this->position_data->find($id);
                    if ($data['contentid']) {
                        $cdata = $this->content->get_data($data['contentid']);
                        if ($cdata['position']) {
                            $cp = @explode(',', $cdata['position']);
                            $pn = array();
                            foreach ($cp as $t) {
                                if ($t != $posid) $pn[] = $t;
                            }
                            $pn = @implode(',', $pn);
                            $cdata['position'] = $pn;

                            $this->content
                                ->where('id', $data['contentid'])
                                ->update($cdata);
                        }
                    }

                    $this->position_data->where('id', $id)->delete();
                }
            }

            return $this->adminMsg($this->getCacheCode('admin/position/cache') . lang('success'), url('admin/position/list', array('posid' => $posid)), 3, 1, 1);
        }

        $this->assign(array(
            'posid' => $posid,
            'list' => $this->position_data->where('posid', $posid)->orderBy('listorder', 'ASC')->get()->toArray(),
        ));
        return $this->display('admin/position_data_list');
    }

    public function adddataAction(Request $request, $posid)
    {
        if (empty($posid)) return $this->adminMsg(lang('a-pos-11'));

        if ($request->method() === 'POST' && $request->get('submit')) {
            $data = $request->get('data');
            if (empty($data['title']) || empty($data['url']) && empty($data['contentid'])) return $this->adminMsg(lang('a-pos-12'));

            $data['posid'] = $posid;
            if ($this->position_data->set(0, $data)) {
                return $this->adminMsg($this->getCacheCode('admin/position/cache') . lang('success'), url('admin/position/list', array('posid' => $posid)), 3, 1, 1);
            } else {
                return $this->adminMsg(lang('a-pos-13'));
            }
        }

        $position = $this->position->find($posid);
        if (empty($position)) return $this->adminMsg(lang('a-pos-11'));

        $this->assign(array(
            'posid' => $posid,
            'position' => $position
        ));
        return $this->display('admin/position_data_add');
    }

    public function editdataAction(Request $request, $posid, $id)
    {
        if (empty($posid)) return $this->adminMsg(lang('a-pos-11'));

        if ($request->method() === 'POST' && $request->get('submit')) {
            $data = $request->get('data');
            if (empty($data['title']) || empty($data['url']) && empty($data['contentid'])) return $this->adminMsg(lang('a-pos-12'));
            $data['posid'] = $posid;

            if ($this->position_data->set($id, $data)) {
                return $this->adminMsg($this->getCacheCode('admin/position/cache') . lang('success'), url('admin/position/list', array('posid' => $posid)), 3, 1, 1);
            } else {
                return $this->adminMsg(lang('a-pos-13'));
            }
        }

        $position = $this->position->find($posid);
        if (empty($position)) return $this->adminMsg(lang('a-pos-11'));
        $data = $this->position_data->find($id);
        if (empty($data)) return $this->adminMsg(lang('a-pos-14'));

        $this->assign(array(
            'data' => $data,
            'posid' => $posid,
            'position' => $position,
        ));
        return $this->display('admin/position_data_add');
    }

    public function cacheAction($show = 0)
    {
        $data = array();
        $position = $this->position->select();
        foreach ($position as $t) {
            $posid = $t['posid'];
            $data[$posid] = $this->position_data->where('posid', $posid)->orderBy('listorder', 'ASC')->orderBy('id', 'DESC')->get();
            if ($data[$posid]) {
                foreach ($data[$posid] as $id => $c) {
                    if ($c['contentid']) {
                        $row = $this->content->find($c['contentid']);
                        if ($row && $row['url'] != $c['url']) {
                            $data[$posid][$id]['url'] = $row['url'];
                            $this->position_data->where('id', $c['id'])->update(array('url' => $row['url']));
                        }
                    }
                }
            }

            $data[$posid]['maxnum'] = $t['maxnum'];
            $data[$posid]['catid'] = $t['catid'];
        }

        $this->cache->set('position', $data);
        return $show ? '' : $this->adminMsg(lang('a-update'), '', 3, 1, 1);
    }

    /**
     * todo 加载内容表中的信息（从内容表中提取）
     */
    public function ajaxloadinfoAction(Request $request)
    {
        $title = $request->get('title');
        $catid = $request->get('catid');
        $thumb = $request->get('thumb');

        $select = $this->content->order('updatetime DESC')->limit(0, 20);
        $select->where('`status`=1');
        if ($catid && $this->cats[$catid]['arrchilds']) $select->where('catid IN (' . $this->cats[$catid]['arrchilds'] . ')');
        if ($title) $select->where('title like "%' . $title . '%"');
        if ($thumb) $select->where('thumb<>""');
        $list = $select->select();

        $tree = new tree();
        $tree->config(array('id' => 'catid', 'parent_id' => 'parentid', 'name' => 'catname'));
        $option = $tree->get_tree($this->cats, 0, null, '&nbsp;|-', 0);

        $this->assign(array(
            'list' => $list,
            'category' => $option
        ));
        return $this->display('admin/position_data_load');
    }
}