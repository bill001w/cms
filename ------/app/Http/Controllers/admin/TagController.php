<?php

namespace App\Http\Controllers\admin;

use App\Servers\dayrui\libraries\auth;
use App\Servers\dayrui\libraries\pagelist;
use App\Servers\drivers\ControllerTool;
use Illuminate\Http\Request;

class TagController extends Admin
{
    protected $tag;
    protected $cat;

    public function __construct(Request $request)
    {
        parent::__construct($request);

        $this->tag = $this->model('tag');
        // get('category')为在category表查找
        $this->cat = $this->db->where('child', '0')->get('category')->result_array();
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

            $this->adminMsg($this->getCacheCode('tag') . lang('success'), url('admin/tag/'), 3, 1, 1);

        } elseif ($request->method() === 'POST' && $request->get('submit_update') && $request->get('form') == 'update') {
            $data = $request->get('data');
            if (empty($data)) $this->adminMsg(lang('a-tag-0'));

            foreach ($data as $id => $t) {
                if ($this->checkRepeat($t, 0, $id)) {
                    $this->adminMsg(lang('a-tag-ex-2'), url('admin/tag'));
                }

                $this->tag->update($t, 'id=' . $id);
            }

            $this->adminMsg($this->getCacheCode('tag') . lang('success'), url('admin/tag/'), 3, 1, 1);
        }

        $page = (int)$request->get('page');
        $page = (!$page) ? 1 : $page;
        $pagelist = new pagelist();
        $pagelist->loadconfig();
        if ($request->method() === 'POST' && $request->get('submit')) {
            $kw = $this->post('kw');
        }
        $where = null;
        $kw = $kw ? $kw : $this->get('kw');
        if ($kw) {
            $where = "name like '%" . $kw . "%'";
        }
        $total = $this->tag->count('tag', null, $where);
        $pagesize = isset($this->site['SITE_ADMIN_PAGESIZE']) && $this->site['SITE_ADMIN_PAGESIZE'] ? $this->site['SITE_ADMIN_PAGESIZE'] : 8;
        $url = url('admin/tag/index', array('page' => '{page}', 'kw' => $kw));
        $select = $this->tag->page_limit($page, $pagesize)->order(array('listorder DESC', 'id DESC'));
        if ($where) {
            $select->where($where);
        }

        $data = $select->select();
        $pagelist = $pagelist->total($total)->url($url)->num($pagesize)->page($page)->output();

        $this->view->assign(array(
            'list' => $data,
            'pagelist' => $pagelist,
            'category' => $this->cat
        ));
        $this->view->display('admin/tag_list');
    }

    public function addAction(Request $request)
    {
        if ($request->method() === 'POST' && $request->get('submit')) {
            $data = $request->get('data');
            if (empty($data['name'])) {
                $this->adminMsg(lang('a-tag-1'));
            }
            if (empty($data['letter'])) {
                $data['letter'] = word2pinyin($data['letter']);
            }
            if ($this->checkRepeat($data, 1, 0)) $this->adminMsg(lang('a-tag-ex-2'), url('admin/tag/add'));
            $data['listorder'] = intval($data['listorder']);

            $this->db->replace('tag', $data);

            $this->adminMsg($this->getCacheCode('tag') . lang('success'), url('admin/tag'), 3, 1, 1);
        }

        $this->view->assign('category', $this->cat);
        $this->view->display('admin/tag_add');
    }

    public function editAction(Request $request, $id)
    {
        $data = $this->tag->find($id);
        if (empty($data)) {
            $this->adminMsg(lang('a-tag-2'));
        }

        if ($request->method() === 'POST' && $request->get('submit')) {
            $data = $request->get('data');
            if (empty($data['name'])) {
                $this->adminMsg(lang('a-tag-1'));
            }
            if (empty($data['letter'])) {
                $data['letter'] = word2pinyin($data['letter']);
            }
            $data['listorder'] = intval($data['listorder']);

            if ($this->checkRepeat($data, 1, $id)) $this->adminMsg(lang('a-tag-ex-2'), url('admin/tag/'));

            $this->tag->update($data, 'id=' . $id);

            $this->adminMsg($this->getCacheCode('tag') . lang('success'), url('admin/tag'), 3, 1, 1);
        }

        $this->view->assign('category', $this->cat);
        $this->view->assign('data', $data);
        $this->view->display('admin/tag_add');
    }

    public function delAction($id = 0, $all = 0)
    {
        if (!auth::check($this->roleid, 'tag-del', 'admin')) {
            $this->adminMsg(lang('a-com-0', array('1' => 'tag', '2' => 'del')));
        }

        $all = $all ? $all : $this->get('all');
        $id = $id ? $id : (int)$this->get('id');
        $this->tag->delete('id=' . $id);
        $all or $this->adminMsg($this->getCacheCode('tag') . lang('success'), url('admin/tag/index'), 3, 1, 1);
    }

    public function importAction(Request $request)
    {
        if ($request->method() === 'POST' && $request->get('submit')) {
            $catid = $this->post('catid');
            $i = $j = $k = 0;
            $file = $_FILES['txt'];
            if ($file['type'] != 'text/plain') {
                $this->adminMsg(lang('a-tag-3', array('1' => $file['type'])));
            }
            if ($file['error']) {
                $this->adminMsg(lang('a-tag-4'));
            }
            if (!file_exists($file['tmp_name'])) {
                $this->adminMsg(lang('a-tag-5'));
            }
            $data = file_get_contents($file['tmp_name']);
            $data = explode(PHP_EOL, $data);

            foreach ($data as $t) {
                $name = trim($t);
                if ($name) {
                    $row = $this->tag->getOne('name=?', $name);
                    if (empty($row)) {
                        $id = $this->db->replace('tag', array('name' => $name, 'letter' => word2pinyin($name), 'listorder' => 0, 'catid' => $catid));
                        if ($id) $i++;
                    } else {
                        $j++;
                    }
                } else {
                    $k++;
                }
            }
            $this->adminMsg($this->getCacheCode('tag') . lang('a-tag-6', array('1' => $i, '2' => $k, '3' => $j)), url('admin/tag/index'), 3, 1, 1);
        }
        $this->view->assign(
            array(
                'category' => $this->cat
            )
        );
        $this->view->display('admin/tag_import');
    }

    public function cacheAction()
    {
        $list = array();
        $data = $this->tag->from(null, 'name,letter')->order('listorder DESC, id DESC')->select();
        if ($data) {
            $cfg = ControllerTool::load_config('config');
            foreach ($data as $t) {
                $list[$t['name']] = array(
                    'name' => $t['name'],
                    'url' => $cfg['SITE_TAG_URL'] ? str_replace('{tag}', $t['letter'], SITE_PATH . $cfg['SITE_TAG_URL']) : url('tag/list', array('kw' => $t['letter']))
                );
            }
        }

        $this->cache->set('tag', $list);
        $this->adminMsg(lang('a-update'), url('admin/tag'), 3, 1, 1);
    }
}