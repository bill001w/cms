<?php

namespace App\Http\Controllers\admin;

use App\Services\dayrui\libraries\pagelist;
use App\Services\drivers\ControllerTool;
use App\Services\libraries\auth;
use App\Services\Models\TagModel;
use Illuminate\Http\Request;

class TagController extends Admin
{
    protected $tag;
    protected $cat;

    public function __construct(Request $request)
    {
        parent::__construct($request);

        $this->tag = new TagModel();
        $this->cat = \DB::SELECT('select * from ' . $this->db_prefix . 'category where child=0', []);
    }

    public function indexAction(Request $request)
    {
        if ($request->method() === 'POST' && $request->get('submit_del') && $request->get('form') == 'del') {
            foreach ($request->all() as $var => $value) {
                if (strpos($var, 'del_') !== false) {
                    $id = (int)str_replace('del_', '', $var);
                    $this->delAction($request, $id, 1);
                }
            }

            return $this->adminMsg($this->getCacheCode('admin/tag/cache') . lang('success'), url('admin/tag/'), 3, 1, 1);

        } elseif ($request->method() === 'POST' && $request->get('submit_update') && $request->get('form') == 'update') {
            // 更新操作，就是直接在index里修改tag
            $data = $request->get('data');
            if (empty($data)) return $this->adminMsg(lang('a-tag-0'));

            foreach ($data as $id => $t) {
                if ($this->checkRepeat($t, 0, $id)) {
                    return $this->adminMsg(lang('a-tag-ex-2'), url('admin/tag'));
                }

                $this->tag->where('id', $id)->update($t);
            }

            return $this->adminMsg($this->getCacheCode('admin/tag/cache') . lang('success'), url('admin/tag/'), 3, 1, 1);
        }

        $page = (int)$request->get('page');
        $page = (!$page) ? 1 : $page;
        $pagelist = new pagelist();
        $pagelist->loadconfig();
        if ($request->method() === 'POST' && $request->get('submit')) {
            $kw = $this->post('kw');
        }

        $pagesize = isset($this->site['SITE_ADMIN_PAGESIZE']) && $this->site['SITE_ADMIN_PAGESIZE'] ? $this->site['SITE_ADMIN_PAGESIZE'] : 8;
        $select = $this->tag->limit($pagesize)->offset(($page - 1)*$pagesize)->orderBy('listorder', 'DESC')->orderBy('id', 'DESC');
        $kw = $kw ? $kw : $this->get('kw');
        if ($kw) {
            $select = $select->where('name', 'like', '%' . $kw . '%');
        }
        $total = $select->count();
        $data = $select->get()->toArray();
        $url = url('admin/tag/index', array('page' => '{page}', 'kw' => $kw));
        $pagelist = $pagelist->total($total)->url($url)->num($pagesize)->page($page)->output();

        $this->assign(array(
            'list' => $data,
            'pagelist' => $pagelist,
            'category' => $this->cat
        ));
        return $this->display('admin/tag_list');
    }

    public function addAction(Request $request)
    {
        if ($request->method() === 'POST' && $request->get('submit')) {
            $data = $request->get('data');
            if (empty($data['name'])) {
                return $this->adminMsg(lang('a-tag-1'));
            }
            if (empty($data['letter'])) {
                $data['letter'] = word2pinyin($data['letter']);
            }
            if ($this->checkRepeat($data, 1, 0)) return $this->adminMsg(lang('a-tag-ex-2'), url('admin/tag/add'));
            $data['listorder'] = intval($data['listorder']);

            $this->tag->create($data);

            return $this->adminMsg($this->getCacheCode('admin/tag/cache') . lang('success'), url('admin/tag'), 3, 1, 1);
        }

        $this->assign('category', $this->cat);
        return $this->display('admin/tag_add');
    }

    public function editAction(Request $request, $id)
    {
        $data = $this->tag->find($id);
        if (empty($data)) {
            return $this->adminMsg(lang('a-tag-2'));
        }

        if ($request->method() === 'POST' && $request->get('submit')) {
            $data = $request->get('data');
            if (empty($data['name'])) {
                return $this->adminMsg(lang('a-tag-1'));
            }
            if (empty($data['letter'])) {
                $data['letter'] = word2pinyin($data['letter']);
            }
            $data['listorder'] = intval($data['listorder']);

            if ($this->checkRepeat($data, 1, $id)) return $this->adminMsg(lang('a-tag-ex-2'), url('admin/tag/'));

            $this->tag->where('id', $id)->update($data);

            return $this->adminMsg($this->getCacheCode('admin/tag/cache') . lang('success'), url('admin/tag'), 3, 1, 1);
        }

        $this->assign('category', $this->cat);
        $this->assign('data', $data);
        return $this->display('admin/tag_add');
    }

    public function delAction(Request $request, $id = 0, $all = 0)
    {
        if (!auth::check($this->roleid, 'tag-del', 'admin')) {
            return $this->adminMsg(lang('a-com-0', array('1' => 'tag', '2' => 'del')));
        }

        $all = $all ? $all : $request->get('all');
        $this->tag->where('id=', $id)->delete();

        return $all ? '' : $this->adminMsg($this->getCacheCode('admin/tag/cache') . lang('success'), url('admin/tag/index'), 3, 1, 1);
    }

    public function importAction(Request $request)
    {
        if ($request->method() === 'POST' && $request->get('submit')) {
            $catid = $this->post('catid');
            $i = $j = $k = 0;
            $file = $_FILES['txt'];
            if ($file['type'] != 'text/plain') {
                return $this->adminMsg(lang('a-tag-3', array('1' => $file['type'])));
            }
            if ($file['error']) {
                return $this->adminMsg(lang('a-tag-4'));
            }
            if (!file_exists($file['tmp_name'])) {
                return $this->adminMsg(lang('a-tag-5'));
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
            return $this->adminMsg($this->getCacheCode('admin/tag/cache') . lang('a-tag-6', array('1' => $i, '2' => $k, '3' => $j)), url('admin/tag/index'), 3, 1, 1);
        }
        $this->assign(
            array(
                'category' => $this->cat
            )
        );
        return $this->display('admin/tag_import');
    }

    public function cacheAction($show = 0)
    {
        $list = array();
        $data = $this->tag->orderBy('listorder', 'DESC')->orderBy('id', 'DESC')->get()->toArray();
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
        return $show ? '' : $this->adminMsg(lang('a-update'), url('admin/tag'), 3, 1, 1);
    }
}