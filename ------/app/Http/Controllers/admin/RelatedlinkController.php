<?php

namespace App\Http\Controllers\admin;

use App\Servers\dayrui\libraries\check;
use App\Servers\dayrui\libraries\pagelist;
use Illuminate\Http\Request;

class RelatedlinkController extends Admin
{
    protected $relatedlink;

    public function __construct(Request $request)
    {
        parent::__construct($request);

        $this->relatedlink = $this->model('relatedlink');
    }

    public function indexAction(Request $request)
    {
        if ($request->method() === 'POST' && $request->get('submit_del') && $request->get('form') == 'del') {
            foreach ($request->all() as $var => $value) {
                if (strpos($var, 'del_') !== false) {
                    $id = (int)str_replace('del_', '', $var);
                    $this->delAction($id, 1);
                }
            }

            $this->adminMsg($this->getCacheCode('relatedlink') . lang('success'), url('admin/relatedlink/'), 3, 1, 1);

        } elseif ($request->method() === 'POST' && $request->get('submit_update') && $request->get('form') == 'update') {
            $data = $request->method() === 'POST' && $request->get('data');
            if (empty($data)) $this->adminMsg(lang('a-tag-0'));
            foreach ($data as $id => $t) {
                $this->relatedlink->update($t, 'id=' . $id);
            }

            $this->adminMsg($this->getCacheCode('relatedlink') . lang('success'), url('admin/relatedlink/'), 3, 1, 1);
        }

        $page = (int)$request->get('page');
        $page = (!$page) ? 1 : $page;
        $pagelist = new pagelist();
        $pagelist->loadconfig();
        if ($request->method() === 'POST' && $request->get('submit')) $kw = $request->method() === 'POST' && $request->get('kw');

        $where = null;
        $kw = $kw ? $kw : $this->get('kw');
        if ($kw) $where = "name like '%" . $kw . "%'";
        $total = $this->relatedlink->count('relatedlink', null, $where);
        $pagesize = isset($this->site['SITE_ADMIN_PAGESIZE']) && $this->site['SITE_ADMIN_PAGESIZE'] ? $this->site['SITE_ADMIN_PAGESIZE'] : 8;
        $url = url('admin/relatedlink/index', array('page' => '{page}', 'kw' => $kw));
        $select = $this->relatedlink->page_limit($page, $pagesize)->order(array('sort DESC', 'id DESC'));
        if ($where) $select->where($where);
        $data = $select->select();
        $pagelist = $pagelist->total($total)->url($url)->num($pagesize)->page($page)->output();

        $this->view->assign(array(
            'list' => $data,
            'pagelist' => $pagelist,
        ));
        $this->view->display('admin/relatedlink_list');
    }

    public function addAction(Request $request)
    {
        if ($request->method() === 'POST' && $request->get('submit')) {
            $data = $request->get('data');
            if (empty($data['name']) || empty($data['url'])) $this->adminMsg(lang('a-tag-12'));
            if (!check::is_url($data['url'])) $this->adminMsg(lang('a-tag-13'));
            $data['sort'] = intval($data['sort']);

            $this->relatedlink->insert($data);

            $this->adminMsg($this->getCacheCode('relatedlink') . lang('success'), url('admin/relatedlink'), 3, 1, 1);
        }

        $this->view->display('admin/relatedlink_add');
    }

    public function editAction(Request $request, $id)
    {
//        $id = (int)$this->get('id');
        $data = $this->relatedlink->find($id);
        if (empty($data)) $this->adminMsg(lang('a-tag-14'));

        if ($request->method() === 'POST' && $request->get('submit')) {
            $data = $request->get('data');
            if (empty($data['name']) || empty($data['url'])) $this->adminMsg(lang('a-tag-12'));
            if (!check::is_url($data['url'])) $this->adminMsg(lang('a-tag-13'));

            $this->relatedlink->update($data, 'id=' . $id);

            $this->adminMsg($this->getCacheCode('relatedlink') . lang('success'), url('admin/relatedlink'), 3, 1, 1);
        }

        $this->view->assign('data', $data);
        $this->view->display('admin/relatedlink_add');
    }

    public function delAction($id = 0, $all = 0)
    {
        if (!auth::check($this->roleid, 'relatedlink-del', 'admin')) $this->adminMsg(lang('a-com-0', array('1' => 'relatedlink', '2' => 'del')));
        $all = $all ? $all : $this->get('all');
        $id = $id ? $id : (int)$this->get('id');
        $this->relatedlink->delete('id=' . $id);
        $all or $this->adminMsg($this->getCacheCode('relatedlink') . lang('success'), url('admin/relatedlink/index'), 3, 1, 1);
    }

    public function importAction(Request $request)
    {
        if ($request->method() === 'POST' && $request->get('submit')) {
            $i = $j = $k = 0;
            $file = $_FILES['txt'];
            if ($file['type'] != 'text/plain') $this->adminMsg(lang('a-tag-3', array('1' => $file['type'])));
            if ($file['error']) $this->adminMsg(lang('a-tag-4'));
            if (!file_exists($file['tmp_name'])) $this->adminMsg(lang('a-tag-5'));
            $data = file_get_contents($file['tmp_name']);
            $data = explode(PHP_EOL, $data);
            foreach ($data as $t) {
                $t = explode(' ', trim($t));
                $name = trim($t[0]);
                $url = trim($t[count($t) - 1]);
                if ($name && check::is_url($url)) {
                    $row = $this->relatedlink->getOne('name=?', $name);
                    if (empty($row)) {
                        $id = $this->relatedlink->insert(array('name' => $name, 'url' => $url));
                        if ($id) $i++;
                    } else {
                        $j++;
                    }
                } else {
                    $k++;
                }
            }
            $this->adminMsg($this->getCacheCode('relatedlink') . lang('a-tag-6', array('1' => $i, '2' => $k, '3' => $j)), url('admin/relatedlink/index'), 3, 1, 1);
        }
        $this->view->display('admin/relatedlink_import');
    }

    public function cacheAction($show = 0)
    {
        $data = $this->relatedlink->from(null, 'name,url')->order('sort DESC, id DESC')->select();
        $list = array();
        if ($data) {
            foreach ($data as $t) {
                $list[$t['name']] = $t;
            }
        }

        $this->cache->set('relatedlink', $list);
        $show or $this->adminMsg(lang('a-update'), url('admin/relatedlink'), 3, 1, 1);
    }
}