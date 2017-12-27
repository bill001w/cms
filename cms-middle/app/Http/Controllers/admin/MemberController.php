<?php

namespace App\Http\Controllers\admin;

use App\Services\dayrui\libraries\check;
use App\Services\dayrui\libraries\pagelist;
use Illuminate\Http\Request;

class MemberController extends Admin
{
    private $mgroup;

    public function __construct(Request $request)
    {
        parent::__construct($request);

        if ($this->config['SYS_MEMBER']) {
            return $this->adminMsg('系统禁止了会员功能');
        }

        $this->mgroup = $this->model('member_group');
    }

    public function indexAction(Request $request, $status = 0)
    {
        if ($request->method() === 'POST' && $request->get('submit') && $request->get('form') == 'search') {
            $kw = $request->get('kw');

        } elseif ($request->method() === 'POST' && $request->get('submit_status_1') && $request->get('form') == 'status_1') {
            foreach ($request->all() as $var => $value) {
                if (strpos($var, 'del_') !== false) {
                    $ids = str_replace('del_', '', $var);
                    list($_id, $_mid) = explode('_', $ids);

                    $this->member->update(array('status' => 1), 'id=' . $_id);
                }
            }

        } elseif ($request->method() === 'POST' && $request->get('submit_status_0') && $request->get('form') == 'status_0') {
            foreach ($request->all() as $var => $value) {
                if (strpos($var, 'del_') !== false) {
                    $ids = str_replace('del_', '', $var);
                    list($_id, $_mid) = explode('_', $ids);

                    $this->member->update(array('status' => 0), 'id=' . $_id);
                }
            }
        }

        $kw = $kw ? $kw : $request->get('kw');
        $page = (int)$request->get('page');
        $page = (!$page) ? 1 : $page;

        $pagelist = new pagelist();
        $pagelist->loadconfig();

        $where = '1';
        if ($kw) $where .= " and username like '%" . $kw . "%'";
        if ($status == 1) {
            $where .= ' and status=1';
        } elseif ($status == 2) {
            $where .= ' and status=0';
        }

        $total = $this->member->count('member', null, $where);
        $pagesize = isset($this->site['SITE_ADMIN_PAGESIZE']) && $this->site['SITE_ADMIN_PAGESIZE'] ? $this->site['SITE_ADMIN_PAGESIZE'] : 8;
        $pagelist = $pagelist->total($total)->url(url('admin/member/index') . '/' . $status . '?page={page}&kw=' . $kw)->num($pagesize)->page($page)->output();

        $data = $this->member->where($where)->page_limit($page, $pagesize)->order(array('status ASC', 'regdate DESC', 'id DESC'))->select();

        $count = array();
        $count[0] = $this->member->count('member', null, '1');
        $count[1] = $this->member->count('member', null, 'status=1');
        $count[2] = $this->member->count('member', null, 'status=0');
        $count[$status] = $total;

        $this->assign(array(
            'kw' => $kw,
            'list' => $data,
            'page' => $page,
            'count' => $count,
            'status' => $status,
            'pagelist' => $pagelist,
            'membermodel' => $this->membermodel,
            'membergroup' => $this->membergroup,
        ));
        return $this->display('admin/member_list');
    }

    public function regAction(Request $request)
    {
        if ($request->method() === 'POST' && $request->get('submit')) {
            $addall = $request->get('addall');
            if ($addall) {
                //批量
                $data = $request->get('members');
                if (empty($data)) return $this->adminMsg(lang('a-mem-6'));
                $data = explode(PHP_EOL, $data);
                $y = $n = 0;

                foreach ($data as $val) {
                    list($username, $password, $email) = explode(' ', $val);
                    $email = trim($email);
                    $username = trim($username);
                    $password = trim($password);
                    if (empty($username) || empty($password) || empty($email)) {
                        $n++;
                    } elseif (!$this->is_username($username)) {
                        $n++;
                    } elseif (!check::is_email($email)) {
                        $n++;
                    } else {
                        $row1 = $this->member->getOne('username=?', $username, 'id');
                        $row2 = $this->member->getOne('email=?', $email, 'id');

                        if (empty($row1) && empty($row2)) {
                            $salt = substr(md5(rand(0, 999)), 0, 10);
                            $insert = array(
                                'salt' => $salt,
                                'regip' => $request->ip(),
                                'email' => $email,
                                'status' => $request->get['data']['status'],
                                'regdate' => time(),
                                'groupid' => 1,
                                'loginip' => '',
                                'logintime' => 0,
                                'lastloginip' => '',
                                'lastlogintime' => 0,
                                'nickname' => '',
                                'randcode' => 0,
                                'credits' => 0,
                                'username' => $username,
                                'password' => md5(md5($password) . $salt . md5($password))
                            );
                            if ($this->member->insert($insert)) {
                                $y++;
                            } else {
                                $n++;
                            }
                        } else {
                            $n++;
                        }
                    }
                }

                return $this->adminMsg(lang('a-mem-7', array('1' => $y, '2' => $n)), url('admin/member/index'), 3, 1, 1);
            } else {
                //注册
                $data = $request->get('data');
                if (empty($data['username']) || empty($data['password']) || empty($data['email'])) return $this->adminMsg(lang('a-mem-8'));
                if (!$this->is_username($data['username'])) return $this->adminMsg(lang('a-mem-9'));
                if (!check::is_email($data['email'])) return $this->adminMsg(lang('a-mem-10'));

                $row = $this->member->getOne('username=?', $data['username'], 'id');
                if ($row) return $this->adminMsg(lang('a-mem-11'));
                $row = $this->member->getOne('email=?', $data['email'], 'id');
                if ($row) return $this->adminMsg(lang('a-mem-12'));
                $salt = substr(md5(rand(0, 999)), 0, 10);

                $insert = array(
                    'salt' => $salt,
                    'email' => $data['email'],
                    'regip' => $request->ip(),
                    'status' => $data['status'],
                    'regdate' => time(),
                    'groupid' => 1,
                    'randcode' => 0,
                    'credits' => 0,
                    'logintime' => 0,
                    'loginip' => '',
                    'lastlogintime' => 0,
                    'lastloginip' => '',
                    'nickname' => '',
                    'username' => $data['username'],
                    'password' => md5(md5($data['password']) . $salt . md5($data['password']))
                );
                if ($this->member->insert($insert)) {
                    return $this->adminMsg(lang('success'), url('admin/member/index'), 3, 1, 1);
                } else {
                    return $this->adminMsg(lang('a-mem-13'));
                }
            }
        }

        $count = array();
        $count[0] = $this->member->count('member', null, '1');
        $count[1] = $this->member->count('member', null, 'status=1');
        $count[2] = $this->member->count('member', null, 'status=0');

        $this->assign(array(
            'count' => $count
        ));
        return $this->display('admin/member_reg');
    }

    public function editAction(Request $request, $id)
    {
        $member = $this->member->find($id);
        if (empty($member)) return $this->adminMsg(lang('a-mem-3'));

        if ($request->method() === 'POST' && $request->get('submit')) {
            $data = $request->get('data');
            if ($request->method() === 'POST' && $request->get('password')) $data['password'] = md5(md5($request->get('password')) . $member['salt'] . md5($request->get('password')));
            foreach ($data as $i => $t) {
                if (is_array($t)) $data[$i] = array2string($t);
            }
            $this->member->update($data, 'id=' . $id);

            return $this->adminMsg(lang('success'), url('admin/member/edit', array('id' => $id)), 3, 1, 1);
        }

        $count = array();
        $count[0] = $this->member->count('member', null, '1');
        $count[1] = $this->member->count('member', null, 'status=1');
        $count[2] = $this->member->count('member', null, 'status=0');

        $this->assign(array(
            'id' => $id,
            'data' => $member,
            'group' => $this->membergroup,
            'count' => $count,
        ));
        return $this->display('admin/member_edit');
    }

    public function delAction($id)
    {
        $data = $this->member->find($id);
        if (empty($data)) return $this->adminMsg(lang('a-mem-3'));
        //删除内容表信息
        $list = $this->content->from(null, 'id,catid')->where('sysadd=0 and create_userid=' . $id)->select();
        foreach ($list as $t) {
            $this->content->del($t['id'], $t['catid']);
        }
        //删除会员
        $this->member->delete('id=' . $id);
        //删除短消息
        $pms = $this->model('member_pms');
        $pms->delete("sendid=" . $id . " AND sendname='" . $data['username'] . "'");
        //删除收藏夹
        $favorite = $this->model('favorite');
        $favorite->delete('userid=' . $id);
        //删除会员附件目录
        $path = 'uploadfiles/member/' . $id . '/';
        if (file_exists($path)) $this->delDir($path);
        return $this->adminMsg(lang('success'), url('admin/member'), 3, 1, 1);
    }

    public function groupAction(Request $request, $type = null)
    {
        switch ($type) {
            case 'add':
                if ($this->isPostForm()) {
                    $data = $request->get('data');
                    $data['listorder'] = intval($data['listorder']);
                    $data['disabled'] = intval($data['disabled']);
                    $data['credits'] = intval($data['credits']);
                    $data['allowpost'] = intval($data['allowpost']);
                    $data['allowpms'] = intval($data['allowpms']);
                    $data['filesize'] = intval($data['filesize']);
                    if (empty($data['name'])) return $this->adminMsg(lang('a-mem-1'));

                    $this->mgroup->insert($data);

                    return $this->adminMsg($this->getCacheCode('member') . lang('success'), url('admin/member/group/'), 3, 1, 1);
                }

                return $this->display('admin/member_group_add');

                break;

            case 'edit':
                $id = (int)$request->get('id');
                if ($this->isPostForm()) {
                    $data = $request->get('data');
                    if (empty($data['name'])) return $this->adminMsg(lang('a-mem-1'));

                    $this->mgroup->update($data, 'id=' . $id);
                    return $this->adminMsg($this->getCacheCode('member') . lang('success'), url('admin/member/group/'), 3, 1, 1);
                }
                $this->assign('data', $this->mgroup->find($id));
                return $this->display('admin/member_group_add');

                break;

            case 'cache':
                $this->cacheAction();

                break;

            case 'delete':
                $id = (int)$request->get('id');
                $this->mgroup->delete('id=' . $id);
                return $this->adminMsg($this->getCacheCode('member') . lang('success'), url('admin/member/group/'), 3, 1, 1);

                break;

            default:
                if ($request->method() === 'POST' && $request->get('submit_order') && $request->get('form') == 'order') {
                    foreach ($request->all() as $var => $value) {
                        if (strpos($var, 'order_') !== false) {
                            $id = (int)str_replace('order_', '', $var);
                            $this->mgroup->update(array('listorder' => $value), 'id=' . $id);
                        }
                    }

                    $this->cacheAction(1);

                } elseif ($request->method() === 'POST' && $request->get('submit_del') && $request->get('form') == 'del') {
                    foreach ($request->all() as $var => $value) {
                        if (strpos($var, 'del_') !== false) {
                            $id = (int)str_replace('del_', '', $var);
                            $this->mgroup->delete('id=' . $id);
                        }
                    }

                    $this->cacheAction(1);
                }

                $page = (int)$request->get('page');
                $page = (!$page) ? 1 : $page;
                $pagelist = new pagelist();
                $pagelist->loadconfig();
                $total = $this->mgroup->count('member_group');
                $pagesize = isset($this->site['SITE_ADMIN_PAGESIZE']) && $this->site['SITE_ADMIN_PAGESIZE'] ? $this->site['SITE_ADMIN_PAGESIZE'] : 8;
                $url = url('admin/member/group', array('page' => '{page}'));
                $select = $this->mgroup->page_limit($page, $pagesize)->order(array('listorder ASC', 'id DESC'));
                $data = $select->select();
                $pagelist = $pagelist->total($total)->url($url)->num($pagesize)->page($page)->output();

                $this->assign(array(
                    'list' => $data,
                    'pagelist' => $pagelist,
                ));
                return $this->display('admin/member_group_list');
        }
    }

    public function cacheAction($show = 0)
    {
        $data = $this->mgroup->order(array('listorder ASC', 'id DESC'))->select();
        $cache = array();
        foreach ($data as $t) {
            $cache[$t[id]] = $t;
        }
        $this->cache->set('membergroup', $cache);
        return  $show or  $this->adminMsg(lang('a-update'), url('admin/member/group/'), 3, 1, 1);
    }

    public function configAction(Request $request)
    {
        $type = $request->get('type') ? $request->get('type') : 'reg';
        $member = $this->cache->get('member');

        if ($request->method() === 'POST' && $request->get('submit')) {
            $data = $request->get('data');
            $data['reg_tpl'] = stripslashes($data['reg_tpl']);
            $data['pass_tpl'] = stripslashes($data['pass_tpl']);
            $data['group_tpl'] = stripslashes($data['group_tpl']);
            $data['username_pattern'] = stripslashes($data['username_pattern']);

            $this->cache->set('member', $data);
            return $this->adminMsg(lang('success'), url('admin/member/config'), 3, 1, 1);
        }

        $this->assign(array(
            'type' => $type,
            'data' => $member,
            'membermodel' => $this->membermodel,
            'membergroup' => $this->membergroup
        ));

        return $this->display('admin/member_config');
    }

    public function pmsAction(Request $request)
    {
        $type = $request->get('type');
        $memberpms = $this->model('member_pms');

        switch ($type) {
            case 'show';
                $id = (int)$request->get('id');
                if ($this->isPostForm()) {
                    if ($id) $memberpms->delete('id=' . $id);
                    return $this->adminMsg(lang('success'), url('admin/member/pms'));
                }
                if (empty($id)) return $this->adminMsg(lang('a-mem-14'));
                $data = $memberpms->find($id);
                if (empty($data)) return $this->adminMsg(lang('a-mem-15'));

                $this->assign(array(
                    'data' => $data,
                    'model' => $this->membermodel,
                    'group' => $this->membergroup
                ));
                return $this->display('admin/member_pms_show');

                break;

            case 'send':
                if ($this->isPostForm()) {
                    $type = $request->get('type');
                    $data = $request->get('data');

                    if (empty($type)) return $this->adminMsg(lang('a-mem-16'));
                    if (empty($data['title']) || empty($data['content'])) return $this->adminMsg(lang('a-mem-17'));

                    $data['sendid'] = $this->userinfo['userid'];
                    $data['isadmin'] = 1;
                    $data['sendname'] = $this->userinfo['username'];
                    $data['sendtime'] = time();
                    $sendtotal = 0;

                    if ($type == 1) {
                        //群发
                        if (empty($data['modelid'])) return $this->adminMsg(lang('a-mem-18'));
                        $where = 'modelid=' . $data['modelid'];
                        if ($data['groupid']) $where .= ' AND groupid=' . $data['groupid'];
                        $list = $this->member->from(null, 'id,username')->where($where)->select();
                        foreach ($list as $row) {
                            $data['toid'] = $row['id'];
                            $data['toname'] = $row['username'];
                            if ($memberpms->insert($data)) $sendtotal++;
                        }
                    } elseif ($type == 2) {
                        //个人
                        unset($data['togroupid'], $data['tomodelid']);
                        if (empty($data['tonames'])) return $this->adminMsg(lang('a-mem-19'));
                        $users = explode(',', $data['tonames']);
                        foreach ($users as $user) {
                            $row = $this->member->from(null, 'id')->where('username=?', $user)->select(false);
                            if ($row) {
                                $data['toid'] = $row['id'];
                                $data['toname'] = $user;
                                if ($memberpms->insert($data)) $sendtotal++;
                            }
                        }
                    }

                    return $this->adminMsg(lang('a-mem-20') . '(' . $sendtotal . ')', url('admin/member/pms'), 3, 1, 1);
                }

                $this->assign(array(
                    'model' => $this->membermodel,
                    'group' => $this->membergroup
                ));
                return $this->display('admin/member_pms_send');

                break;

            default:
                if ($this->isPostForm()) {
                    $ids = $request->method() === 'POST' && $request->get('ids');
                    $ids = implode(',', $ids);
                    if ($ids) $memberpms->delete('id IN(' . $ids . ')');
                }

                $page = $request->get('page') ? (int)$request->get('page') : 1;
                $pagelist = new pagelist();
                $pagelist->loadconfig();
                $where = null;
                if ($request->get('toid')) $where = 'toid=' . $request->get('toid');
                $total = $memberpms->count('member_pms', 'id', $where);
                $pagesize = isset($this->site['SITE_ADMIN_PAGESIZE']) && $this->site['SITE_ADMIN_PAGESIZE'] ? $this->site['SITE_ADMIN_PAGESIZE'] : 8;
                $url = url('admin/member/pms', array('page' => '{page}'));
                if ($request->get('toid')) $url = url('admin/member/pms', array('toid' => $request->get('toid'), 'page' => '{page}'));
                $select = $memberpms->page_limit($page, $pagesize)->order('sendtime DESC');
                if ($request->get('toid')) $select->where('toid=' . $request->get('toid'));
                $data = $select->select();
                $pagelist = $pagelist->total($total)->url($url)->num($pagesize)->page($page)->output();

                $this->assign(array(
                    'list' => $data,
                    'model' => $this->membermodel,
                    'group' => $this->membergroup,
                    'pagelist' => $pagelist
                ));
                return $this->display('admin/member_pms_list');

                break;
        }
    }

    public function testAction(Request $request)
    {
        $host = isset($_GET['host']) && trim($_GET['host']) ? trim($_GET['host']) : exit('0');
        $username = isset($_GET['username']) && trim($_GET['username']) ? trim($_GET['username']) : exit('0');
        if (@mysql_connect($host, $username, $password)) {
            exit('1');
        } else {
            exit('0');
        }
    }

    public function ajaxemailAction(Request $request)
    {
        $email = $request->get('email');
        if (!check::is_email($email)) exit('<b><font color=red>' . lang('a-mem-21') . '</font></b>');
        $id = $request->get('id');
        if (empty($email)) exit('<b><font color=red>' . lang('a-mem-22') . '</font></b>');
        $where = $id ? "email='" . $email . "' and id<>" . $id : "email='" . $email . "'";
        $data = $this->member->getOne($where);
        if ($data) exit('<b><font color=red>' . lang('a-mem-23') . '</font></b>');
        exit('<b><font color=green>√</font></b>');
    }

    public function ajaxusernameAction(Request $request)
    {dd(1);
        $name = $request->get('username');
        if (!$this->is_username($name)) exit('<b><font color=red>' . lang('a-mem-24') . '</font></b>');
        if (empty($name)) exit('<b><font color=red>' . lang('a-mem-25') . '</font></b>');
        $data = $this->member->getOne('username=?', $name, 'id');
        if ($data) exit('<b><font color=red>' . lang('a-mem-11') . '</font></b>');
        exit('<b><font color=green>√</font></b>');
    }
}