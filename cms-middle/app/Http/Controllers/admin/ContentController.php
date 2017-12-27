<?php

namespace App\Http\Controllers\admin;

use App\Services\dayrui\libraries\pagelist;
use App\Services\libraries\auth;
use App\Services\libraries\tree;
use App\Services\models\Position_dataModel;
use App\Services\models\PositionModel;
use Illuminate\Http\Request;

class ContentController extends Admin
{
    private $tree;

    public function __construct(Request $request)
    {
        parent::__construct($request);

        $this->tree = new tree();
        $this->tree->config(array('id' => 'catid', 'parent_id' => 'parentid', 'name' => 'catname'));
    }

    public function indexAction(Request $request, $catid, $recycle = null)
    {
        if ($request->method() === 'POST' && $request->get('submit') && $request->get('form') == 'search') {
            $kw = $request->get('kw');
            $catid = (int)$request->get('catid') ? (int)$request->get('catid') : $catid;
            $stype = $request->get('stype');

            unset($_GET['page']);

        } elseif ($request->method() === 'POST' && $request->get('submit_order') && $request->get('form') == 'order') {
            foreach ($request->all() as $var => $value) {
                if (strpos($var, 'order_') !== false) {
                    $id = (int)str_replace('order_', '', $var);
                    $this->content->where('id', (int)$id)->update(array('listorder' => $value));
                }
            }

        } elseif ($request->method() === 'POST' && $request->get('submit_status_1') && $request->get('form') == 'status_1') {
            //标记通过
            $success = 0;
            foreach ($request->all() as $var => $value) {
                if (strpos($var, 'del_') !== false) {
                    $ids = str_replace('del_', '', $var);
                    list($_id, $_catid) = explode('_', $ids);
                    $this->db->where('id', (int)$_id)->update(array('status' => 1));
                    $this->toHtml((int)$_id);
                    $success++;
                }
            }

            return $this->adminMsg(lang('success') . '(' . $success . ')', '', 3, 1, 1);

        } elseif ($request->method() === 'POST' && $request->get('submit_status_3') && $request->get('form') == 'status_3') {
            //标记回收站
            $success = 0;
            foreach ($request->all() as $var => $value) {
                if (strpos($var, 'del_') !== false) {
                    $ids = str_replace('del_', '', $var);
                    list($_id, $_catid) = explode('_', $ids);
                    $this->db->where('id', (int)$_id)->update(array('status' => 0));
                    $this->toHtml((int)$_id);
                    $success++;
                }
            }

            return $this->adminMsg(lang('success') . '(' . $success . ')', '', 3, 1, 1);

        } elseif ($request->method() === 'POST' && $request->get('submit_status_5') && $request->get('form') == 'status_5') {
            //微信推送
            $success = 0;
            $weixint = '';
            foreach ($request->all() as $var => $value) {
                if (strpos($var, 'del_') !== false) {
                    $ids = str_replace('del_', '', $var);
                    list($_id, $_catid) = explode('_', $ids);
                    $weixint .= $_id . ',';
                    $success++;
                }
            }
            $this->content->post_weixin(trim($weixint, ','), $this->input->get('catid'));

            return $this->adminMsg(lang('success') . '(' . $success . ')', '', 3, 1, 1);

        } elseif ($request->method() === 'POST' && $request->get('form') == 'del') {
            //删除操作
            foreach ($request->all() as $var => $value) {
                if (strpos($var, 'del_') !== false) {
                    $ids = str_replace('del_', '', $var);
                    list($_catid, $_id) = explode('_', $ids);

                    $this->delAction($_catid, $_id, 1);
                }
            }

        } elseif ($request->method() === 'POST' && $request->get('submit_move') && $request->get('form') == 'move') {
            //移动操作
            $mcatid = (int)$request->get('movecatid');
            if (empty($mcatid)) {
                return $this->adminMsg(lang('a-con-0'));
            }

            $mcat = $this->cats[$mcatid];
            $modelName = 'App\\Servers\\models\\' . ucfirst($mcat) . 'Model';
            $mtable = new $modelName();
            $success = 0;

            foreach ($request->all() as $var => $value) {
                if (strpos($var, 'del_') !== false) {
                    $ids = str_replace('del_', '', $var);
                    list($_id, $_catid) = explode('_', $ids);
                    $cat = $this->cats[$_catid];
                    if ($cat['modelid'] == $mcat['modelid']) {
                        //执行移动
                        $this->content->where('id', (int)$_id)->update(array('catid' => $mcatid));
                        $mtable->where('id', (int)$_id)->update(array('catid' => $mcatid));
                        $this->toHtml($_id);
                        $success++;
                    }
                }
            }

            return $this->adminMsg(lang('success') . '(' . $success . ')', '', 3, 1, 1);
        }

        $modelid = $this->cache->get('content_cat_data')[$catid]['modelid'];
        $model = $this->cache->get('model');
        if ($this->adminPost($model[$modelid]['setting']['auth'])) return $this->adminMsg(lang('a-cat-100', array('1' => $this->userinfo['rolename'])));

        $kw = $kw ? $kw : $request->get('kw');
        $page = (int)$request->get('page') ? (int)$request->get('page') : 1;
        $stype = isset($stype) ? $stype : (int)$request->get('stype');    // 0标题，1会员，2管理

        $sql = $this->content->where('catid', $catid);
        if ($kw && $stype == 0) {
            $sql = $sql->where('title', 'like', '%' . $kw . '%');
        } elseif ($kw && $stype == 1) {
            $sql = $sql->where('username', $kw)->where('sysadd', 0);
        } elseif ($kw && $stype == 2) {
            $sql = $sql->where('username', $kw)->where('sysadd', 1);
        }
        if ($recycle) {
            $sql = $sql->where('status', 0);
        } else {
            $sql = $sql->where('status', 1);
        }

        $pagelist = new pagelist();
        $pagelist->loadconfig();
        $pagesize = isset($this->site['SITE_ADMIN_PAGESIZE']) && $this->site['SITE_ADMIN_PAGESIZE'] ? $this->site['SITE_ADMIN_PAGESIZE'] : 8;
        $url = url('admin/content/index/' . $catid) . '?page={page}&recycle=' . $recycle;
        if ($kw) {
            $url .= '&kw=' . $kw;
        }
        if ($stype) {
            $url .= '&stype=' . $stype;
        }

        $data = $sql->offset(($page - 1) * $pagesize)->limit($pagesize)->orderBy('listorder', 'DESC')->orderBy('update_time', 'DESC')->get()->toArray();
        $total = $sql->count();
        $pagelist = $pagelist->total($total)->url($url)->num($pagesize)->page($page)->output();

        $count = array();
        if ($recycle) {
            $count[0] = $total;
            $total = (int)$this->content->where('catid', $catid)->where('status', 1)->count();
        } else {
            $count[0] = (int)$this->content->where('catid', $catid)->where('status', 0)->count();
        }
        $count[1] = (int)$this->content->where('catid', $catid)->where('status', 3)->count();    //待审
        $count[2] = (int)$this->content->where('catid', $catid)->where('status', 2)->count();    //拒绝

        $this->assign(array(
            'kw' => $kw,
            'page' => $page,
            'catid' => $catid,
            'list' => $data,
            'count' => $count,
            'total' => $total,
            'recycle' => $recycle,
            'pagelist' => $pagelist,
            'category' => $this->tree->get_tree($this->cats, $this->cats[$catid]['parentid'], $catid, ''),
            'tpl' => 'admin/content_default',
        ));
        return $this->display('admin/content_list');
    }

    public function addAction(Request $request, $catid)
    {
        $modelid = $this->cache->get('content_cat_data')[$catid]['modelid'];
        $model = $this->cache->get('model');
        if ($this->adminPost($model[$modelid]['setting']['auth'])) return $this->adminMsg(lang('a-cat-100', array('1' => $this->userinfo['rolename'])));

        $tableName = $model[$modelid]['tablename'];
        $modelName = 'App\\Servers\\models\\' . ucfirst($tableName) . 'Model';
        if (!class_exists($modelName)) {
            return $this->adminMsg('你添加的表还没有对应的Model，请添加！');
        }
        $contentModel = new $modelName();
        if (!$contentModel->is_table_exists($this->db_prefix . $tableName)) {
            return $this->adminMsg('你还没有添加的对应的表，请添加！');
        }

        $fields = \Schema::getColumnListing($this->db_prefix . $tableName);
        if ($request->method() === 'POST' && $request->get('submit')) {
            $data = $request->get('data');
            if (empty($data['catid'])) {
                return $this->adminMsg(lang('a-con-4'));
            }
            if (empty($data['title'])) {
                return $this->adminMsg(lang('a-con-5'));
            }
            if ($this->adminPost($this->cats[$data['catid']]['setting'])) {
                return $this->adminMsg(lang('a-cat-100', array('1' => $this->userinfo['rolename'])));
            }

            $this->checkFields($fields, $data, 1);

            if ($request->get('updatetime') == 2 || $request->get('updatetime') == 1) {
                $data['updatetime'] = time();
            } elseif ($request->get('updatetime') == 3) {
                $data['updatetime'] = $data['select_time'];
            }

            $data['sysadd'] = 1;
            $data['modelid'] = $modelid;
            $data['create_username'] = $this->userinfo['username'];
            $data['relation'] = formatStr($data['relation']);
            $data['position'] = @implode(',', $data['position']);
            $data['create_time'] = time();

            $this->postEvent($data, 'before', 'admin');    //发布前事件
            $result = $this->content->set(0, $model[$modelid]['tablename'], $data);
            if (!is_numeric($result)) {
                return $this->adminMsg($result);
            }

            $data['id'] = $result;
            $this->postEvent($data, 'later', 'admin');    //发布后事件
            if ($this->site['SITE_MAP_AUTO'] == true) {
                $this->sitemap();
            }
            $this->toHtml($data);
            $this->setPosition($data['position'], $result, $data);

            $msg = '<a href="' . url('admin/content/add', array('catid' => $data['catid'])) . '" style="font-size:14px;">' . lang('a-con-7') . '</a>&nbsp;&nbsp;<a href="' . url('admin/content/index', array('catid' => $data['catid'])) . '" style="font-size:14px;">' . lang('a-con-8') . '</a>';
            return $this->adminMsg(lang('a-con-9') . '<div style="padding-top:10px;">' . $msg . '</div>', '', 3, 0, 1);
        }

        $position = $this->model('position');
        $data_fields = $this->getEditor();
        $this->assign(array(
            'catid' => $catid,
            'data' => array('catid' => $request->get('catid')),
            'position' => $position->select(),
            'category' => $this->tree->get_tree($this->cats, $this->cats[$catid]['parentid'], $catid, ''),
            'data_fields' => $data_fields
        ));
        return $this->display('admin/content_add');
    }

    public function duplicateAction(Request $request)
    {
        $model = $this->get_model();
        $id = (int)$request->get('id');
        $data = $this->content->get_data($id);
        $catid = $request->get('catid');

        $modelid = $data['modelid'];
        $table = $this->model($model[$modelid]['tablename']);
        $table_data = $table->find($id);

        $data = array_merge($data, $table_data);//合并主附表数据

        if (empty($data)) {
            return $this->adminMsg(lang('a-con-10'));
        }
        if (!isset($model[$modelid])) {
            return $this->adminMsg(lang('a-con-3'));
        }
        $data['sysadd'] = 1;
        $data['modelid'] = $modelid;
        $data['username'] = $this->userinfo['username'];
        $data['relation'] = formatStr($data['relation']);
        $data['position'] = @implode(',', $data['position']);
        $data['inputtime'] = time();

        $result = $this->content->set(0, $model[$modelid]['tablename'], $data);//添加数据
        if (!is_numeric($result)) {
            return $this->adminMsg($result);
        }
        $back = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : url('admin/content/', array('modelid' => $this->cats[$catid]['modelid']));
        return $this->adminMsg(lang('success'), $back, 3, 1, 1);

    }

    public function editAction(Request $request)
    {
        $id = (int)$request->get('id');
        $data = $this->content->get_data($id);
        if (empty($data)) {
            return $this->adminMsg(lang('a-con-10'));
        }
        $catid = $data['catid'];
        $model = $this->get_model();
        $modelid = $data['modelid'];
        if (!isset($model[$modelid])) {
            return $this->adminMsg(lang('a-con-3'));
        }
        //模型投稿权限验证
        if ($this->adminPost($model[$modelid]['setting']['auth'])) {
            return $this->adminMsg(lang('a-cat-100', array('1' => $this->userinfo['rolename'])));
        }
        $fields = $model[$modelid]['fields'];
        $isUser = $data['sysadd'] && $data['username'] == $this->userinfo['username'] ? 1 : 0;
        if ($request->method() === 'POST' && $request->get('submit')) {
            $posi = $data['position'];
            $_data = $data;
            unset($data);
            $data = $request->method() === 'POST' && $request->get('data');
            if (empty($data['title'])) {
                return $this->adminMsg(lang('a-con-5'));
            }
            if ($data['catid'] != $catid && $modelid != $this->cats[$data['catid']]['modelid']) {
                return $this->adminMsg(lang('a-con-6'));
            }
            //投稿权限验证
            if (!$isUser && $this->adminPost($this->cats[$data['catid']]['setting'])) {
                return $this->adminMsg(lang('a-cat-100', array('1' => $this->userinfo['rolename'])));
            }
            $this->checkFields($fields, $data, 1);
            if ($request->method() === 'POST' && $request->get('updatetime') == 2) {
                $data['updatetime'] = time();
            } elseif ($request->method() === 'POST' && $request->get('updatetime') == 3) {
                $data['updatetime'] = $data['select_time'];
            } else {
                $data['updatetime'] = $_data['updatetime'];
            }
            // 判断复选框问题
            foreach ($fields['data'] as $t) {
                if ($t['formtype'] == 'checkbox' && !$data[$t['field']]) {
                    $data[$t['field']] = '';
                }
            }
            $data['id'] = $id;
            $data['modelid'] = (int)$modelid;
            $data['relation'] = formatStr($data['relation']);
            $data['position'] = @implode(',', $data['position']);
            $data['inputtime'] = $_data['inputtime'];
            $data['id'] = $result = $this->content->set($id, $model[$modelid]['tablename'], $data);
            if (!is_numeric($result)) {
                return $this->adminMsg($result);
            }
            if ($this->site['SITE_MAP_AUTO'] == true) {
                $this->sitemap();
            }
            $this->toHtml($data);
            $this->setPosition($data['position'], $result, $data, $posi);
            return $this->adminMsg(lang('success'), ($request->method() === 'POST' && $request->get('backurl') ? $request->method() === 'POST' && $request->get('backurl') : url('admin/content/index', array('modelid' => $modelid, 'catid' => $catid))), 3, 1, 1);
        }
        //附表内容
        $table = $this->model($model[$modelid]['tablename']);
        $table_data = $table->find($id);
        if ($table_data) {
            $data = array_merge($data, $table_data);
        } //合并主表和附表
        $position = $this->model('position');
        $data_fields = $this->getFields($fields, $data);    //自定义字段
        if ($data['status'] == 3) {    //该文档处于待审时
            $this->assign('verify', $this->verify->find($id));
        }
        $this->assign(array(
            'data' => $data,
            'catid' => $catid,
            'model' => $model[$modelid],
            'modelid' => $modelid,
            'backurl' => isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '',
            'category' => $this->tree->get_model_tree($this->cats, 0, $catid, '|-', $modelid, null, null, $this->userinfo['roleid']),
            'position' => $position->where('site=' . $this->siteid)->select(),
            'data_fields' => $data_fields,
            'relation_ids' => ',' . $data['relation']
        ));
        return $this->display('admin/content_add');
    }

    public function delAction($catid = 0, $id = 0, $all)
    {
        if (!auth::check($this->roleid, 'content-del', 'admin')) {
            return $this->adminMsg(lang('a-com-0', array('1' => 'content', '2' => 'del')));
        }

        $modelid = $this->cache->get('content_cat_data')[$catid]['modelid'];
        $model = $this->cache->get('model');
        if ($this->adminPost($model[$modelid]['setting']['auth'])) return $this->adminMsg(lang('a-cat-100', array('1' => $this->userinfo['rolename'])));

        $this->content->del($id, $catid);

        $back = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : url('admin/content/', array('catid' => $catid));
        return $all ? '' : $this->adminMsg(lang('success'), $back, 3, 1, 1);
    }

    public function verifyAction(Request $request, $catid, $status = 2)
    {
        if ($request->method() === 'POST' && $request->get('submit') && $request->get('form') == 'search') {
            //搜索参数设置

            $kw = $request->get('kw');
            $catid = (int)$request->get('catid') ? (int)$request->get('catid') : $catid;
            $stype = $request->get('stype');

            unset($_GET['page']);

        } elseif ($request->method() === 'POST' && $request->get('form') == 'del') {
            //删除操作

            foreach ($request->all() as $var => $value) {
                if (strpos($var, 'del_') !== false) {
                    $ids = str_replace('del_', '', $var);
                    list($_id, $_catid) = explode('_', $ids);
                    if ($this->verifyPost($this->cats[$_catid]['setting'])) return $this->adminMsg(lang('a-mod-219', array('1' => $this->cats[$_catid]['catname'])));

                    $this->content->verify((int)$_id, 0);
                }
            }

        } elseif ($request->method() === 'POST' && $request->get('submit_status_1') && $request->get('form') == 'status_1') {
            //审核通过

            $success = 0;
            foreach ($request->all() as $var => $value) {
                if (strpos($var, 'del_') !== false) {
                    $ids = str_replace('del_', '', $var);
                    list($_id, $_catid) = explode('_', $ids);

                    if ($this->verifyPost($this->cats[$_catid]['setting'])) return $this->adminMsg(lang('a-mod-219', array('1' => $this->cats[$_catid]['catname'])));

                    $this->content->verify((int)$_id, 1);
                    $this->toHtml((int)$_id);
                    $success++;
                }
            }

            return $this->adminMsg(lang('success') . '(' . $success . ')', '', 3, 1, 1);

        } elseif ($request->method() === 'POST' && $request->get('submit_status_0') && $request->get('form') == 'status_0') {
            //标记未审核

            $success = 0;
            foreach ($request->all() as $var => $value) {
                if (strpos($var, 'del_') !== false) {
                    $ids = str_replace('del_', '', $var);
                    list($_id, $_catid) = explode('_', $ids);

                    if ($this->verifyPost($this->cats[$_catid]['setting'])) return $this->adminMsg(lang('a-mod-219', array('1' => $this->cats[$_catid]['catname'])));

                    $this->content->verify((int)$_id, 3);
                    $this->toHtml((int)$_id);
                    $success++;
                }
            }

            return $this->adminMsg(lang('success') . '(' . $success . ')', '', 3, 1, 1);

        } elseif ($request->method() === 'POST' && $request->get('submit_status_2') && $request->get('form') == 'status_2') {
            //标记拒绝

            $success = 0;
            foreach ($_POST as $var => $value) {
                if (strpos($var, 'del_') !== false) {
                    $ids = str_replace('del_', '', $var);
                    list($_id, $_catid) = explode('_', $ids);

                    if ($this->verifyPost($this->cats[$_catid]['setting'])) return $this->adminMsg(lang('a-mod-219', array('1' => $this->cats[$_catid]['catname'])));

                    $this->content->verify((int)$_id, 2);
                    $this->toHtml((int)$_id);
                    $success++;
                }
            }

            return $this->adminMsg(lang('success') . '(' . $success . ')', '', 3, 1, 1);
        }

        $kw = $kw ? $kw : $request->get('kw');
        $page = (int)$request->get('page') ? (int)$request->get('page') : 1;
        $stype = isset($stype) ? $stype : (int)$request->get('stype');

        $modelid = $this->cache->get('content_cat_data')[$catid]['modelid'];
        $model = $this->cache->get('model');
        if ($this->adminPost($model[$modelid]['setting']['auth'])) return $this->adminMsg(lang('a-cat-100', array('1' => $this->userinfo['rolename'])));

        $pagelist = new pagelist();
        $pagelist->loadconfig();

        $where = '`status`=' . $status;
        if ($catids = $this->getVerifyCatid()) {    //角色审核权限
            $where .= ' and catid not in (' . implode(',', $catids) . ')';
        }
        $where .= ' and catid=' . $catid;
        if ($kw && $stype == 0) {
            $where .= " and title like '%" . $kw . "%'";
        } elseif ($kw && $stype == 1) {
            $where .= " and create_username='" . $kw . "'";
        } elseif ($kw && $stype == 2) {
            $where .= " and verify_username='" . $kw . "'";
        }
        $total = $this->content->count(null, $where);
        $pagesize = isset($this->site['SITE_ADMIN_PAGESIZE']) && $this->site['SITE_ADMIN_PAGESIZE'] ? $this->site['SITE_ADMIN_PAGESIZE'] : 8;
        $url = url('admin/content/verify/' . $catid) . '?page={page}&status=' . $status;
        if ($kw) {
            $url .= '&kw=' . $kw;
        }
        if ($stype) {
            $url .= '&stype=' . $stype;
        }

        $data = $this->content->from(null, 'id,catid,modelid,title,update_time,create_userid,create_username')->where($where)->page_limit($page, $pagesize)->order('update_time DESC')->select();
        $count = array();
        $pagelist = $pagelist->total($total)->url($url)->num($pagesize)->page($page)->output();
        $count[0] = (int)$this->content->count(null, 'catid=' . $catid . ' AND status=0');
        if ($status == 2) {
            $count[2] = $total;
            $count[1] = (int)$this->content->count(null, 'catid=' . $catid . ' AND status=3');    //待审
        } else {
            $count[1] = $total;
            $count[2] = (int)$this->content->count(null, 'catid=' . $catid . ' AND status=2');    //拒绝
        }
        $total = (int)$this->content->count(null, 'catid=' . $catid . ' AND status=1');    //全部

        $this->assign(array(
            'a' => 'verify',
            'kw' => $kw,
            'page' => $page,
            'list' => $data,
            'total' => $total,
            'catid' => $catid,
            'count' => $count,
            'status' => $status,
            'pagelist' => $pagelist,
            'category' => $this->tree->get_tree($this->cats, $this->cats[$catid]['parentid'], $catid, ''),
            'tpl' => 'admin/content_default',
        ));
        return $this->display('admin/content_list');
    }

    public function editverifyAction(Request $request)
    {
        $id = (int)$request->get('id');
        $data = $this->verify->find($id);
        if (empty($data)) {
            return $this->adminMsg(lang('a-con-10'));
        }
        $data = string2array($data['content']);
        $catid = $data['catid'];
        $model = $this->get_model();
        $modelid = $data['modelid'];
        if (!isset($model[$modelid])) {
            return $this->adminMsg(lang('a-con-3'));
        }
        if ($this->verifyPost($this->cats[$catid]['setting'])) {
            return $this->adminMsg(lang('a-mod-219', array('1' => $this->cats[$catid]['catname'])));
        }
        //模型投稿权限验证
        if ($this->adminPost($model[$modelid]['setting']['auth'])) {
            return $this->adminMsg(lang('a-cat-100', array('1' => $this->userinfo['rolename'])));
        }
        $fields = $model[$modelid]['fields'];
        if ($request->method() === 'POST' && $request->get('submit')) {
            $_data = $data;
            $data = $request->method() === 'POST' && $request->get('data');
            if (empty($data['title'])) {
                return $this->adminMsg(lang('a-con-5'));
            }
            if ($data['catid'] != $catid && $modelid != $this->cats[$data['catid']]['modelid']) {
                return $this->adminMsg(lang('a-con-6'));
            }
            //投稿权限验证
            if (!$isUser && $this->adminPost($this->cats[$data['catid']]['setting'])) {
                return $this->adminMsg(lang('a-cat-100', array('1' => $this->userinfo['rolename'])));
            }
            $this->checkFields($fields, $data, 1);
            if (isset($_data['inputtime'])) {
                $data['inputtime'] = $_data['inputtime'];
            }
            // 判断复选框问题
            foreach ($fields['data'] as $t) {
                if ($t['formtype'] == 'checkbox' && !$data[$t['field']]) {
                    $data[$t['field']] = '';
                }
            }
            $data['sysadd'] = 0;
            $data['userid'] = $_data['userid'];
            $data['status'] = $data['status'];
            $data['modelid'] = (int)$modelid;
            $data['username'] = $_data['username'];
            $data['updatetime'] = $_data['updatetime'];
            $result = $this->content->member($id, $model[$modelid]['tablename'], $data);
            if (!is_numeric($result)) {
                return $this->adminMsg($result);
            }
            if ($this->site['SITE_MAP_AUTO'] == true) {
                $this->sitemap();
            }
            return $this->adminMsg(lang('success'), ($request->method() === 'POST' && $request->get('backurl') ? $request->method() === 'POST' && $request->get('backurl') : url('admin/content/verify')), 3, 1, 1);
        }
        $this->assign(array(
            'data' => $data,
            'model' => $model[$modelid],
            'modelid' => $modelid,
            'backurl' => isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '',
            'category' => $this->tree->get_model_tree($this->cats, 0, $catid, '|-', $modelid, null, null, $this->userinfo['roleid']),
            'data_fields' => $this->getFields($fields, $data),
        ));
        return $this->display('admin/content_add');
    }

    public function delverifyAction(Request $request, $id = 0, $all = 0)
    {
        $id = $id ? $id : (int)$request->get('id');
        $all = $all ? $all : 0;
        $data = $this->verify->find($id);

        if ($this->verifyPost($this->cats[$data['catid']]['setting'])) {
            return $this->adminMsg(lang('a-mod-219', array('1' => $this->cats[$data['catid']]['catname'])));
        }

        $this->content->update(array('status' => 1), 'id=' . $id);
        $this->verify->delete('id=' . $id);
        return $all or $this->adminMsg(lang('success'), '', 3, 1, 1);
    }

    public function getTag($data)
    {
        $data['keywords'] = str_replace('，', ',', $data['keywords']);
        $names = @explode(',', $data['keywords']);
        $tag = array();
        foreach ($names as $name) {
            $tag = array_merge_recursive(array(array('catid' => $data['catid'], 'name' => trim($name))), $tag);
        }

        return $tag;
    }

    public function ajaxkwAction(Request $request)
    {
        $data = $request->method() === 'POST' && $request->get('data');
        if (empty($data)) {
            exit('');
        }
        echo getKw($data);
    }

    public function ajaxtitleAction(Request $request)
    {
        $id = (int)$request->method() === 'POST' && $request->get('id');
        $title = $request->method() === 'POST' && $request->get('title');
        if (empty($title)) {
            exit(lang('a-con-11'));
        }
        $where = $id ? "title='" . $title . "' and id<>" . $id : "title='" . $title . "'";
        $data = $this->content->getOne($where);
        if ($data) {
            exit(lang('a-con-12'));
        }
        exit('0');
    }

    public function ajaxloadinfoAction(Request $request)
    {
        $kw = urldecode($request->get('kw'));
        $title = $request->method() === 'POST' && $request->get('title');
        $catid = (int)$request->method() === 'POST' && $request->get('catid');
        $select = $this->content->order('updatetime DESC')->limit(0, 20);
        $select->where('`status`=1');
        if ($title) {
            $select->where('title like "%' . $title . '%"');
        }
        if ($catid && $this->cats[$catid]['arrchilds']) {
            $select->where('catid IN (' . $this->cats[$catid]['arrchilds'] . ')');
        }
        if (empty($title) && $kw) {
            $i = 1;
            $kw = explode(',', $kw);
            foreach ($kw as $keyword) {
                $i ? $select->where('title like "%' . $keyword . '%"') : $select->orwhere('title like "%' . $keyword . '%"');
                $i = 0;
            }
        }
        $this->assign(array(
            'list' => $select->select(),
            'category' => $this->tree->get_tree($this->cats, 0, null, '&nbsp;|-', 0)
        ));
        return $this->display('admin/content_data_load');
    }

    public function updateurlAction(Request $request)
    {
        if ($this->isPostForm()) {
            $cats = null;
            $catids = $request->method() === 'POST' && $request->get('catids');
            if ($catids && !in_array(0, $catids)) {
                $cats = @implode(',', $catids);
            } else {
                foreach ($this->cats as $c) {
                    if ($c['typeid'] == 1) $cats[$c['catid']] = $c['catid'];
                }
                $cats = @implode(',', $cats);
            }
            if (empty($cats)) {
                echo '
				<style type="text/css">div, a { color: #777777;}</style>
			    <div style="font-size:12px;padding-top:0px;">
				<font color=red><b>' . lang('a-con-14') . '<b></font>
				</div>
				';
                exit;
            }
            $url = url('admin/content/updateurl', array('submit' => 1, 'catids' => $cats, 'nums' => $request->method() === 'POST' && $request->get('nums')));
            echo '
			<style type="text/css">div, a { color: #777777;}</style>
			<div style="font-size:12px;padding-top:0px;">
			<a href="' . $url . '">' . lang('a-con-15') . '</a>
			<meta http-equiv="refresh" content="0; url=' . $url . '">
			</div>
			</div>
			';
            exit;
        }
        if ($request->get('submit')) {
            $mark = 0;
            $cats = array();
            $catids = $request->get('catids');
            $cats = @explode(',', $catids);
            $catid = $request->get('catid') ? $request->get('catid') : $cats[0];
            $cat = isset($this->cats[$catid]) ? $this->cats[$catid] : null;
            if (!$cat) {
                echo '
				<style type="text/css">div, a { color: #777777;}</style>
			    <div style="font-size:12px;padding-top:0px;">
				<font color=green><b>' . lang('a-con-16') . '<b></font>
				</div>
				';
                exit;
            }
            $page = $request->get('page') ? $request->get('page') : 1;
            $nums = $request->get('nums') ? $request->get('nums') : 100;
            $where = 'catid IN (' . $cat['arrchilds'] . ')';
            $count = $this->content->count(null, $where);
            $total = ceil($count / $nums);
            $list = $this->content->where($where)->page_limit($page, $nums)->select();
            if (empty($list)) {
                $mark = $_catid = 0;
                foreach ($cats as $c) {
                    if ($catid == $c) {
                        $mark = 1;
                        continue;
                    }
                    if ($mark == 1) {
                        $_catid = $c;
                        break;
                    }
                }
                if (!isset($this->cats[$_catid])) {
                    echo '
					<style type="text/css">div, a { color: #777777;}</style>
			        <div style="font-size:12px;padding-top:0px;">
					<font color=green><b>' . lang('a-con-16') . '<b></font>
					</div>
					';
                    exit;
                }
                $url = url('admin/content/updateurl', array('submit' => 1, 'nums' => $nums, 'page' => 1, 'catid' => $_catid, 'catids' => $catids));
                echo '
				<style type="text/css">div, a { color: #777777;}</style>
			    <div style="font-size:12px;padding-top:0px;">
				<a href="' . $url . '">' . lang('a-con-17', array('1' => $this->cats[$_catid]['catname'])) . '</a>
				<meta http-equiv="refresh" content="0; url=' . $url . '">
				</div>
				';
                exit;
            } else {
                foreach ($list as $t) {
                    $this->content->update(array('url' => $this->getUrl($t)), 'id=' . $t['id']);
                }
                $url = url('admin/content/updateurl', array('submit' => 1, 'nums' => $nums, 'page' => $page + 1, 'catid' => $catid, 'catids' => $catids));
                echo '
				<style type="text/css">div, a { color: #777777;}</style>
			    <div style="font-size:12px;padding-top:0px;">
				<a href="' . $url . '">' . lang('a-con-18', array('1' => $this->cats[$catid]['catname'], '2' => $page, '3' => $total)) . '</a>
				<meta http-equiv="refresh" content="0; url=' . $url . '">
				</div>
				';
                exit;
            }
        } else {
            $this->assign('category', $this->tree->get_tree($this->cats, 0, null, '&nbsp;|-', true));
            return $this->display('admin/content_url');
        }
    }

    private function toHtml($data)
    {
        if (is_array($data) && isset($data['id'])) $this->createShow($data);
        if (is_numeric($data)) {
            $data = $this->content->find((int)$data);
            $this->createShow($data);
        }
    }

    private function setPosition($insert_ids, $cid, $data, $position = null)
    {
        if (empty($cid)) {
            return false;
        }
        $pos = new Position_dataModel();
        $arrid = @explode(',', $insert_ids);
        if ($data['url'] == '') {
            $data['url'] = getUrl($data);
        }
        //增加推荐位
        if (is_array($arrid)) {
            foreach ($arrid as $sid) {
                if ($sid) {
                    $row = $pos->where('posid',(int)$sid)->where('contentid', (int)$cid)->get()->toArray();
                    if ($row) {
                        if (!auth::check($this->roleid, 'position-edit', 'admin')) {
                            return $this->adminMsg(lang('a-com-0', array('1' => 'position', '2' => 'edit')));
                        }
                        $set = array(
                            'url' => $data['url'],
                            'catid' => (int)$data['catid'],
                            'title' => $data['title'],
                            'thumb' => $data['thumb'],
                            'description' => $data['description']
                        );
                        $pos->where('id', $row['id'])->update($set);
                    } else {
                        if (!auth::check($this->roleid, 'position-add', 'admin')) {
                            return $this->adminMsg(lang('a-com-0', array('1' => 'position', '2' => 'add')));
                        }
                        $set = array(
                            'url' => $data['url'],
                            'catid' => (int)$data['catid'],
                            'title' => $data['title'],
                            'thumb' => $data['thumb'],
                            'posid' => (int)$sid,
                            'contentid' => $cid,
                            'description' => $data['description']
                        );
                        $pos->create($set);
                    }
                }
            }
        }
        //删除推荐位
        $old_ids = @explode(',', $position);
        if (is_array($old_ids)) {
            foreach ($old_ids as $sid) {
                if (!in_array($sid, $arrid) && $sid) {
                    if (!auth::check($this->roleid, 'position-del', 'admin')) {
                        return $this->adminMsg(lang('a-com-0', array('1' => 'position', '2' => 'del')));
                    }
                    $pos->where('posid', $sid)->where('contentid', $cid)->delete();
                }
            }
        }
        //更新缓存
        $data = array();
        $pmodel = new PositionModel();
        $position = $pmodel->all();
        foreach ($position as $t) {
            $posid = $t['posid'];
            $data[$posid] = $pos->where('posid=' . $posid)->order('listorder ASC, id DESC')->select();
            $data[$posid]['catid'] = $t['catid'];
            $data[$posid]['maxnum'] = $t['maxnum'];
        }
        //写入缓存文件中
        $this->cache->set('position', $data);
    }

    public function cacheAction($show = 0)
    {
        $data = $this->content->getData();
        $cat_data = array();
        foreach ($data as $t) {
            if (!isset($cat_data[$t['catid']])) {
                $cat_data[$t['catid']]['modelid'] = $t['modelid'];
                $cat_data[$t['catid']]['tablename'] = $this->cache->get('model')[$t['modelid']]['tablename'];
            }

            $cat_data[$t['catid']][] = $t;
        }

        $this->cache->set('content_data', $data);
        $this->cache->set('content_cat_data', $cat_data);

        return $show ? '' : $this->adminMsg(lang('a-update'), '', 3, 1, 1);
    }
}