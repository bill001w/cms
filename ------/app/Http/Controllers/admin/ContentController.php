<?php

namespace App\Http\Controllers\admin;

use App\Servers\dayrui\libraries\auth;
use App\Servers\dayrui\libraries\pagelist;
use App\Servers\libraries\tree;
use Illuminate\Http\Request;

class ContentController extends Admin
{
    private $tree;
    private $table;
    private $verify;

    public function __construct(Request $request)
    {
        parent::__construct($request);

        $this->table = 'content_1';
        $this->tree = new tree();
        $this->tree->config(array('id' => 'catid', 'parent_id' => 'parentid', 'name' => 'catname'));
    }

    public function indexAction(Request $request, $catid, $modelid, $recycle = null)
    {
        if ($request->method() === 'POST' && $request->get('submit') && $request->get('form') == 'search') {
            $kw = $request->get('kw');
            $catid = (int)$request->get('catid');
            $stype = $request->get('stype');

            unset($_GET['page']);
        } elseif ($request->method() === 'POST' && $request->get('submit_order') && $request->get('form') == 'order') {
            foreach ($request->all() as $var => $value) {
                if (strpos($var, 'order_') !== false) {
                    $id = (int)str_replace('order_', '', $var);
                    $this->db->where('id', (int)$id)->update($this->table, array('listorder' => $value));
                }
            }
        } elseif ($request->method() === 'POST' && $request->get('submit_status_1') && $request->get('form') == 'status_1') {
            //标记通过
            $success = 0;
            foreach ($request->all() as $var => $value) {
                if (strpos($var, 'del_') !== false) {
                    $ids = str_replace('del_', '', $var);
                    list($_id, $_catid) = explode('_', $ids);
                    $this->db->where('id', (int)$_id)->update($this->table, array('status' => 1));
                    $this->toHtml((int)$_id);
                    $success++;
                }
            }

            $this->adminMsg(lang('success') . '(' . $success . ')', '', 3, 1, 1);
        } elseif ($request->method() === 'POST' && $request->get('submit_status_3') && $request->get('form') == 'status_3') {
            //标记回收站
            $success = 0;
            foreach ($request->all() as $var => $value) {
                if (strpos($var, 'del_') !== false) {
                    $ids = str_replace('del_', '', $var);
                    list($_id, $_catid) = explode('_', $ids);
                    $this->db->where('id', (int)$_id)->update($this->table, array('status' => 0));
                    $this->toHtml((int)$_id);
                    $success++;
                }
            }

            $this->adminMsg(lang('success') . '(' . $success . ')', '', 3, 1, 1);
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

            $this->adminMsg(lang('success') . '(' . $success . ')', '', 3, 1, 1);
        } elseif ($request->method() === 'POST' && $request->get('form') == 'del') {    //删除操作
            foreach ($request->all() as $var => $value) {
                if (strpos($var, 'del_') !== false) {
                    $ids = str_replace('del_', '', $var);
                    list($_id, $_catid) = explode('_', $ids);
                    $this->delAction($_id, $_catid, 1);
                }
            }

        } elseif ($request->method() === 'POST' && $request->get('submit_move') && $request->get('form') == 'move') {
            //移动操作
            $mcatid = (int)$request->get('movecatid');
            if (empty($mcatid)) {
                $this->adminMsg(lang('a-con-0'));
            }
            $mcat = $this->cats[$mcatid];
            $mtable = $this->model($mcat['tablename']);
            $success = 0;

            foreach ($request->all() as $var => $value) {
                if (strpos($var, 'del_') !== false) {
                    $ids = str_replace('del_', '', $var);
                    list($_id, $_catid) = explode('_', $ids);
                    $cat = $this->cats[$_catid];
                    if ($cat['modelid'] == $mcat['modelid']) { //执行移动
                        $this->db->where('id', (int)$_id)->update($this->table, array('catid' => $mcatid));
                        $mtable->update(array('catid' => $mcatid), 'id=' . (int)$_id);
                        $this->toHtml($_id);
                        $success++;
                    }
                }
            }

            $this->adminMsg(lang('success') . '(' . $success . ')', '', 3, 1, 1);
        }

        $kw = $kw ? $kw : $request->get('kw');
        $page = (int)$request->get('page') ? (int)$request->get('page') : 1;
        $stype = isset($stype) ? $stype : (int)$request->get('stype');    // 0标题，1会员，2管理

        $model = $this->get_model();
        if (empty($modelid)) {
            $this->adminMsg(lang('a-con-1'));
        }
        if (!isset($model[$modelid])) {
            $this->adminMsg(lang('a-con-2', array('1' => $modelid)));
        }
        if ($this->adminPost($model[$modelid]['setting']['auth'])) {
            $this->adminMsg(lang('a-cat-100', array('1' => $this->userinfo['rolename'])));
        }

        $where = $catid ? 'catid=' . $catid : 'modelid=' . $modelid;
        if ($kw && $stype == 0) {
            $where .= " and title like '%" . $kw . "%'";
        } elseif ($kw && $stype == 1) {
            $where .= " and username='" . $kw . "' and sysadd=0";
        } elseif ($kw && $stype == 2) {
            $where .= " and username='" . $kw . "' and sysadd=1";
        }
        if ($recycle) {
            $where .= ' and `status`=0';
        } else {
            $where .= ' and `status`=1';
        }

        $pagelist = new pagelist();
        $pagelist->loadconfig();
        $total = $this->content->_count(null, $where); //统计数量
        $pagesize = isset($this->site['SITE_ADMIN_PAGESIZE']) && $this->site['SITE_ADMIN_PAGESIZE'] ? $this->site['SITE_ADMIN_PAGESIZE'] : 8;
        $url = url('admin/content/index/' . $catid . '/' . $modelid) . '?page={page}&recycle=' . $recycle;
        if ($kw) {
            $url .= '&kw=' . $kw;
        }
        if ($stype) {
            $url .= '&stype=' . $stype;
        }

        $data = $this->content->from(null, '*')->where($where)->page_limit($page, $pagesize)->order(array('listorder DESC', 'update_time DESC'))->select();

        $count = array(); //统计各个状态的数据量
        $pagelist = $pagelist->total($total)->url($url)->num($pagesize)->page($page)->output();

        if ($recycle) {
            $count[0] = $total;
            $total = (int)$this->content->_count(null, 'catid=' . $catid . ' and modelid=' . $modelid . ' AND status=1');
        } else {
            $count[0] = (int)$this->content->_count(null, 'catid=' . $catid . ' and modelid=' . $modelid . ' AND status=0');
        }
        $count[1] = (int)$this->content->_count(null, 'catid=' . $catid . ' and modelid=' . $modelid . ' AND status=3');    //待审
        $count[2] = (int)$this->content->_count(null, 'catid=' . $catid . ' and modelid=' . $modelid . ' AND status=2');    //拒绝

        $table = $model[$modelid]['tablename'];

        $this->view->assign(array(
            'kw' => $kw,
            'list' => $data,
            'page' => $page,
            'catid' => $catid,
            'count' => $count,
            'total' => $total,
            'model' => $model[$modelid],
            'modelid' => $modelid,
            'recycle' => $recycle,
            'pagelist' => $pagelist,
            'category' => $this->tree->get_model_tree($this->cats, 0, null, '|-', $modelid),
            'tpl' => !is_file(VIEW_DIR . 'admin/' . $table . '.html') ? 'admin/content_default' : 'admin/' . $table,
        ));
        $this->view->display('admin/content_list');
    }

    public function addAction(Request $request, $catid, $modelid)
    {
        $model = $this->get_model();
        if (!isset($model[$modelid])) {
            $this->adminMsg(lang('a-con-3'));
        }
        if ($this->adminPost($model[$modelid]['setting']['auth'])) {
            $this->adminMsg(lang('a-cat-100', array('1' => $this->userinfo['rolename'])));
        }

        $tableName = $model[$modelid]['tablename'];
        $modelName = 'App\\Servers\\models\\' . ucfirst($tableName) . 'Model';
        if (!class_exists($modelName)) {
            $this->adminMsg('你添加的表还没有对应的Model，请添加！');
        }
        $contentModel = new $modelName();
        if (!$contentModel->is_table_exists($tableName)) {
            $this->adminMsg('你还没有添加的对应的表，请添加！');
        }

        $fields = $contentModel->get_table_fields();
        if ($request->method() === 'POST' && $request->get('submit')) {
            $data = $request->get('data');
            if (empty($data['catid'])) {
                $this->adminMsg(lang('a-con-4'));
            }
            if (empty($data['title'])) {
                $this->adminMsg(lang('a-con-5'));
            }
            if ($this->cats[$data['catid']]['modelid'] != $modelid) {
                $this->adminMsg(lang('a-con-6'));
            }
            if ($this->adminPost($this->cats[$data['catid']]['setting'])) {
                $this->adminMsg(lang('a-cat-100', array('1' => $this->userinfo['rolename'])));
            }

            $this->checkFields($fields, $data, 1);

            if ($request->get('updatetime') == 2 || $request->get('updatetime') == 1) {
                $data['updatetime'] = time();
            } elseif ($request->get('updatetime') == 3) {
                $data['updatetime'] = $data['select_time'];
            }

            $data['sysadd'] = 1;
            $data['modelid'] = $modelid;
            $data['username'] = $this->userinfo['username'];
            $data['relation'] = formatStr($data['relation']);
            $data['position'] = @implode(',', $data['position']);
            $data['inputtime'] = time();

            $this->postEvent($data, 'before', 'admin');    //发布前事件
            $result = $this->content->set(0, $model[$modelid]['tablename'], $data);
            if (!is_numeric($result)) {
                $this->adminMsg($result);
            }

            $data['id'] = $result;
            $this->postEvent($data, 'later', 'admin');    //发布后事件
            if ($this->site['SITE_MAP_AUTO'] == true) {
                $this->sitemap();
            }
            $this->toHtml($data);
            $this->setPosition($data['position'], $result, $data);

            $msg = '<a href="' . url('admin/content/add', array('catid' => $data['catid'], 'modelid' => $modelid)) . '" style="font-size:14px;">' . lang('a-con-7') . '</a>&nbsp;&nbsp;<a href="' . url('admin/content/index', array('catid' => $data['catid'], 'modelid' => $modelid)) . '" style="font-size:14px;">' . lang('a-con-8') . '</a>';
            $this->adminMsg(lang('a-con-9') . '<div style="padding-top:10px;">' . $msg . '</div>', '', 3, 0, 1);
        }

        $position = $this->model('position');
        $data_fields = $this->getEditor();
        $this->view->assign(array(
            'catid' => $catid,
            'data' => array('catid' => $request->get('catid')),
            'model' => $model[$modelid],
            'modelid' => $modelid,
            'position' => $position->where('site=' . $this->siteid)->select(),
            'category' => $this->tree->get_model_tree($this->cats, 0, $request->get('catid'), '|-', $modelid, null, null, $this->userinfo['roleid']),
            'data_fields' => $data_fields
        ));
        $this->view->display('admin/content_add');
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
            $this->adminMsg(lang('a-con-10'));
        }
        if (!isset($model[$modelid])) {
            $this->adminMsg(lang('a-con-3'));
        }
        $data['sysadd'] = 1;
        $data['modelid'] = $modelid;
        $data['username'] = $this->userinfo['username'];
        $data['relation'] = formatStr($data['relation']);
        $data['position'] = @implode(',', $data['position']);
        $data['inputtime'] = time();

        $result = $this->content->set(0, $model[$modelid]['tablename'], $data);//添加数据
        if (!is_numeric($result)) {
            $this->adminMsg($result);
        }
        $back = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : url('admin/content/', array('modelid' => $this->cats[$catid]['modelid']));
        $this->adminMsg(lang('success'), $back, 3, 1, 1);

    }

    public function editAction(Request $request)
    {
        $id = (int)$request->get('id');
        $data = $this->content->get_data($id);
        if (empty($data)) {
            $this->adminMsg(lang('a-con-10'));
        }
        $catid = $data['catid'];
        $model = $this->get_model();
        $modelid = $data['modelid'];
        if (!isset($model[$modelid])) {
            $this->adminMsg(lang('a-con-3'));
        }
        //模型投稿权限验证
        if ($this->adminPost($model[$modelid]['setting']['auth'])) {
            $this->adminMsg(lang('a-cat-100', array('1' => $this->userinfo['rolename'])));
        }
        $fields = $model[$modelid]['fields'];
        $isUser = $data['sysadd'] && $data['username'] == $this->userinfo['username'] ? 1 : 0;
        if ($request->method() === 'POST' && $request->get('submit')) {
            $posi = $data['position'];
            $_data = $data;
            unset($data);
            $data = $request->method() === 'POST' && $request->get('data');
            if (empty($data['title'])) {
                $this->adminMsg(lang('a-con-5'));
            }
            if ($data['catid'] != $catid && $modelid != $this->cats[$data['catid']]['modelid']) {
                $this->adminMsg(lang('a-con-6'));
            }
            //投稿权限验证
            if (!$isUser && $this->adminPost($this->cats[$data['catid']]['setting'])) {
                $this->adminMsg(lang('a-cat-100', array('1' => $this->userinfo['rolename'])));
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
                $this->adminMsg($result);
            }
            if ($this->site['SITE_MAP_AUTO'] == true) {
                $this->sitemap();
            }
            $this->toHtml($data);
            $this->setPosition($data['position'], $result, $data, $posi);
            $this->adminMsg(lang('success'), ($request->method() === 'POST' && $request->get('backurl') ? $request->method() === 'POST' && $request->get('backurl') : url('admin/content/index', array('modelid' => $modelid, 'catid' => $catid))), 3, 1, 1);
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
            $this->view->assign('verify', $this->verify->find($id));
        }
        $this->view->assign(array(
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
        $this->view->display('admin/content_add');
    }

    public function delAction($catid = 0, $id = 0)
    {
        if (!auth::check($this->roleid, 'content-del', 'admin')) {
            $this->adminMsg(lang('a-com-0', array('1' => 'content', '2' => 'del')));
        }

        $back = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : url('admin/content/', array('modelid' => $this->cats[$catid]['modelid']));
        $model = $this->get_model();
        //模型投稿权限验证
        if ($this->adminPost($model[$this->cats[$catid]['modelid']]['setting']['auth'])) {
            $this->adminMsg(lang('a-cat-100', array('1' => $this->userinfo['rolename'])));
        }

        $this->content->del($id, $catid);
        $this->adminMsg(lang('success'), $back, 3, 1, 1);
    }

    public function verifyAction(Request $request, $catid, $modelid, $status = 2)
    {
        //搜索参数设置
        if ($request->method() === 'POST' && $request->get('submit') && $request->get('form') == 'search') {
            $kw = $request->get('kw');
            $catid = (int)$request->get('catid');
            $stype = $request->get('stype');

            unset($_GET['page']);

            //删除操作
        } elseif ($request->method() === 'POST' && $request->get('form') == 'del') {
            foreach ($_POST as $var => $value) {
                if (strpos($var, 'del_') !== false) {
                    $ids = str_replace('del_', '', $var);
                    list($_id, $_catid) = explode('_', $ids);
                    if ($this->verifyPost($this->cats[$_catid]['setting'])) $this->adminMsg(lang('a-mod-219', array('1' => $this->cats[$_catid]['catname'])));

                    $this->content->verify((int)$_id, 0);
                }
            }

            //审核通过
        } elseif ($request->method() === 'POST' && $request->get('submit_status_1') && $request->get('form') == 'status_1') {
            $success = 0;
            foreach ($request->all() as $var => $value) {
                if (strpos($var, 'del_') !== false) {
                    $ids = str_replace('del_', '', $var);
                    list($_id, $_catid) = explode('_', $ids);

                    if ($this->verifyPost($this->cats[$_catid]['setting'])) $this->adminMsg(lang('a-mod-219', array('1' => $this->cats[$_catid]['catname'])));

                    $this->content->verify((int)$_id, 1);
                    $this->toHtml((int)$_id);
                    $success++;
                }
            }

            $this->adminMsg(lang('success') . '(' . $success . ')', '', 3, 1, 1);

            //标记未审核
        } elseif ($request->method() === 'POST' && $request->get('submit_status_0') && $request->get('form') == 'status_0') {
            $success = 0;
            foreach ($request->all() as $var => $value) {
                if (strpos($var, 'del_') !== false) {
                    $ids = str_replace('del_', '', $var);
                    list($_id, $_catid) = explode('_', $ids);

                    if ($this->verifyPost($this->cats[$_catid]['setting'])) $this->adminMsg(lang('a-mod-219', array('1' => $this->cats[$_catid]['catname'])));

                    $this->content->verify((int)$_id, 3);
                    $this->toHtml((int)$_id);
                    $success++;
                }
            }

            $this->adminMsg(lang('success') . '(' . $success . ')', '', 3, 1, 1);

            //标记拒绝
        } elseif ($request->method() === 'POST' && $request->get('submit_status_2') && $request->get('form') == 'status_2') {
            $success = 0;
            foreach ($_POST as $var => $value) {
                if (strpos($var, 'del_') !== false) {
                    $ids = str_replace('del_', '', $var);
                    list($_id, $_catid) = explode('_', $ids);

                    if ($this->verifyPost($this->cats[$_catid]['setting'])) $this->adminMsg(lang('a-mod-219', array('1' => $this->cats[$_catid]['catname'])));

                    $this->content->verify((int)$_id, 2);
                    $this->toHtml((int)$_id);
                    $success++;
                }
            }

            $this->adminMsg(lang('success') . '(' . $success . ')', '', 3, 1, 1);
        }

        $kw = $kw ? $kw : $request->get('kw');
        $page = (int)$request->get('page') ? (int)$request->get('page') : 1;
        $stype = isset($stype) ? $stype : (int)$request->get('stype');

        $model = $this->get_model();
        if (empty($modelid)) $this->adminMsg(lang('a-con-1'));
        if (!isset($model[$modelid])) $this->adminMsg(lang('a-con-2', array('1' => $modelid)));
        if ($this->adminPost($model[$modelid]['setting']['auth'])) $this->adminMsg(lang('a-cat-100', array('1' => $this->userinfo['rolename'])));

        $pagelist = new pagelist();
        $pagelist->loadconfig();

        $where = '`status`=' . $status;
        if ($catids = $this->getVerifyCatid()) {    //角色审核权限
            $where .= ' and catid not in (' . implode(',', $catids) . ')';
        }
        $where .= $catid ? ' and catid=' . $catid : ' and modelid=' . $modelid;
        if ($kw && $stype == 0) {
            $where .= " and title like '%" . $kw . "%'";
        } elseif ($kw && $stype == 1) {
            $where .= " and create_username='" . $kw . "'";
        } elseif ($kw && $stype == 2) {
            $where .= " and verify_username='" . $kw . "'";
        }
        $total = $this->content->count('content_1', null, $where);
        $pagesize = isset($this->site['SITE_ADMIN_PAGESIZE']) && $this->site['SITE_ADMIN_PAGESIZE'] ? $this->site['SITE_ADMIN_PAGESIZE'] : 8;
        $url = url('admin/content/verify/' . $catid . '/' . $modelid) . '?page={page}&status=' . $status;
        if ($kw) {
            $url .= '&kw=' . $kw;
        }
        if ($stype) {
            $url .= '&stype=' . $stype;
        }

        $data = $this->content->from(null, 'id,catid,modelid,title,update_time,create_userid,create_username')->where($where)->page_limit($page, $pagesize)->order('update_time DESC')->select();
        $count = array();
        $pagelist = $pagelist->total($total)->url($url)->num($pagesize)->page($page)->output();
        $count[0] = (int)$this->content->_count(null, 'modelid=' . $modelid . ' AND status=0');
        if ($status == 2) {
            $count[2] = $total;
            $count[1] = (int)$this->content->count('content_' . $this->siteid . '_verify', null, 'catid=' . $catid . ' and modelid=' . $modelid . ' AND status=3');    //待审
        } else {
            $count[1] = $total;
            $count[2] = (int)$this->content->count('content_' . $this->siteid . '_verify', null, 'catid=' . $catid . ' and modelid=' . $modelid . ' AND status=2');    //拒绝
        }
        $total = (int)$this->content->_count(null, ($catid ? 'catid=' . $catid . ' and ' : '') . 'modelid=' . $modelid . ' AND status=1');    //全部

        $table = $model[$modelid]['tablename'];
        $this->view->assign(array(
            'a' => 'verify',
            'kw' => $kw,
            'page' => $page,
            'list' => $data,
            'total' => $total,
            'model' => $model[$modelid],
            'catid' => $catid,
            'count' => $count,
            'status' => $status,
            'modelid' => $modelid,
            'pagelist' => $pagelist,
            'category' => $this->tree->get_model_tree($this->cats, 0, null, '|-', $modelid),
            'tpl' => !is_file(VIEW_DIR . 'admin/' . $table . '.html') ? 'admin/content_default' : 'admin/' . $table,
        ));
        $this->view->display('admin/content_list');
    }

    /**
     * 修改待审
     */
    public function editverifyAction(Request $request)
    {
        $id = (int)$request->get('id');
        $data = $this->verify->find($id);
        if (empty($data)) {
            $this->adminMsg(lang('a-con-10'));
        }
        $data = string2array($data['content']);
        $catid = $data['catid'];
        $model = $this->get_model();
        $modelid = $data['modelid'];
        if (!isset($model[$modelid])) {
            $this->adminMsg(lang('a-con-3'));
        }
        if ($this->verifyPost($this->cats[$catid]['setting'])) {
            $this->adminMsg(lang('a-mod-219', array('1' => $this->cats[$catid]['catname'])));
        }
        //模型投稿权限验证
        if ($this->adminPost($model[$modelid]['setting']['auth'])) {
            $this->adminMsg(lang('a-cat-100', array('1' => $this->userinfo['rolename'])));
        }
        $fields = $model[$modelid]['fields'];
        if ($request->method() === 'POST' && $request->get('submit')) {
            $_data = $data;
            $data = $request->method() === 'POST' && $request->get('data');
            if (empty($data['title'])) {
                $this->adminMsg(lang('a-con-5'));
            }
            if ($data['catid'] != $catid && $modelid != $this->cats[$data['catid']]['modelid']) {
                $this->adminMsg(lang('a-con-6'));
            }
            //投稿权限验证
            if (!$isUser && $this->adminPost($this->cats[$data['catid']]['setting'])) {
                $this->adminMsg(lang('a-cat-100', array('1' => $this->userinfo['rolename'])));
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
                $this->adminMsg($result);
            }
            if ($this->site['SITE_MAP_AUTO'] == true) {
                $this->sitemap();
            }
            $this->adminMsg(lang('success'), ($request->method() === 'POST' && $request->get('backurl') ? $request->method() === 'POST' && $request->get('backurl') : url('admin/content/verify')), 3, 1, 1);
        }
        $this->view->assign(array(
            'data' => $data,
            'model' => $model[$modelid],
            'modelid' => $modelid,
            'backurl' => isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '',
            'category' => $this->tree->get_model_tree($this->cats, 0, $catid, '|-', $modelid, null, null, $this->userinfo['roleid']),
            'data_fields' => $this->getFields($fields, $data),
        ));
        $this->view->display('admin/content_add');
    }

    /**
     * 删除待审文档
     */
    public function delverifyAction(Request $request, $id = 0, $all = 0)
    {
        $id = $id ? $id : (int)$request->get('id');
        $all = $all ? $all : 0;
        $data = $this->verify->find($id);

        if ($this->verifyPost($this->cats[$data['catid']]['setting'])) {
            $this->adminMsg(lang('a-mod-219', array('1' => $this->cats[$data['catid']]['catname'])));
        }

        $this->content->update(array('status' => 1), 'id=' . $id);
        $this->verify->delete('id=' . $id);
        $all or $this->adminMsg(lang('success'), '', 3, 1, 1);
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

    /**
     * 获取关键字
     */
    public function ajaxkwAction(Request $request)
    {
        $data = $request->method() === 'POST' && $request->get('data');
        if (empty($data)) {
            exit('');
        }
        echo getKw($data);
    }

    /**
     * 标题是否重复检查
     */
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

    /**
     * 加载内容表中的信息
     */
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
        $this->view->assign(array(
            'list' => $select->select(),
            'category' => $this->tree->get_tree($this->cats, 0, null, '&nbsp;|-', 0)
        ));
        $this->view->display('admin/content_data_load');
    }

    /**
     * 更新url地址
     */
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
            $count = $this->content->_count(null, $where);
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
            $this->view->assign('category', $this->tree->get_tree($this->cats, 0, null, '&nbsp;|-', true));
            $this->view->display('admin/content_url');
        }
    }

    /**
     * 生成/删除内容页HTML文件
     */
    private function toHtml($data)
    {
        if (is_array($data) && isset($data['id'])) $this->createShow($data);
        if (is_numeric($data)) {
            $data = $this->content->find((int)$data);
            $this->createShow($data);
        }
    }

    /**
     * 增加/删除推荐位
     */
    private function setPosition($insert_ids, $cid, $data, $position = null)
    {
        if (empty($cid)) {
            return false;
        }
        $pos = $this->model('position_data');
        $arrid = @explode(',', $insert_ids);
        if ($data['url'] == '') {
            $data['url'] = getUrl($data);
        }
        //增加推荐位
        if (is_array($arrid)) {
            foreach ($arrid as $sid) {
                if ($sid) {
                    $row = $pos->from(null, 'id')->where('posid=' . (int)$sid . ' and contentid=' . (int)$cid)->select(false);
                    if ($row) {
                        if (!auth::check($this->roleid, 'position-edit', 'admin')) {
                            $this->adminMsg(lang('a-com-0', array('1' => 'position', '2' => 'edit')));
                        }
                        $set = array(
                            'url' => $data['url'],
                            'catid' => (int)$data['catid'],
                            'title' => $data['title'],
                            'thumb' => $data['thumb'],
                            'description' => $data['description']
                        );
                        $pos->update($set, 'id=' . $row['id']);
                    } else {
                        if (!auth::check($this->roleid, 'position-add', 'admin')) {
                            $this->adminMsg(lang('a-com-0', array('1' => 'position', '2' => 'add')));
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
                        $pos->insert($set);
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
                        $this->adminMsg(lang('a-com-0', array('1' => 'position', '2' => 'del')));
                    }
                    $pos->delete('posid=' . $sid . ' AND contentid=' . $cid);
                }
            }
        }
        //更新缓存
        $data = array();
        $pmodel = $this->model('position');
        $position = $pmodel->where('site=' . $this->siteid)->select();
        foreach ($position as $t) {
            $posid = $t['posid'];
            $data[$posid] = $pos->where('posid=' . $posid)->order('listorder ASC, id DESC')->select();
            $data[$posid]['catid'] = $t['catid'];
            $data[$posid]['maxnum'] = $t['maxnum'];
        }
        //写入缓存文件中
        $this->cache->set('position_' . $this->siteid, $data);
    }
}