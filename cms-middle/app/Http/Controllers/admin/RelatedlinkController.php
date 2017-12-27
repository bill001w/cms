<?php

namespace App\Http\Controllers\admin;

use App\Services\dayrui\libraries\check;
use App\Services\dayrui\libraries\pagelist;
use App\Services\libraries\auth;
use App\Services\Models\RelatedLinkModel;
use Illuminate\Http\Request;

class RelatedlinkController extends Admin
{
    protected $relatedlink;

    public function __construct(Request $request)
    {
        parent::__construct($request);

        $this->relatedlink = new RelatedLinkModel();
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

            return $this->adminMsg($this->getCacheCode('admin/relatedlink/cache') . lang('success'), url('admin/relatedlink/'), 3, 1, 1);

        } elseif ($request->method() === 'POST' && $request->get('submit_update') && $request->get('form') == 'update') {
            $data = $request->get('data');
            if (empty($data)) return $this->adminMsg(lang('a-tag-0'));
            foreach ($data as $id => $t) {
                $this->relatedlink->where('id', $id)->update($t);
            }

            return $this->adminMsg($this->getCacheCode('admin/relatedlink/cache') . lang('success'), url('admin/relatedlink/'), 3, 1, 1);
        }

        $page = (int)$request->get('page');
        $page = (!$page) ? 1 : $page;
        $pagelist = new pagelist();
        $pagelist->loadconfig();

        $sql = $this->relatedlink;
        if ($request->method() === 'POST' && $request->get('submit')) $kw = $request->get('kw');
        $kw = $kw ? $kw : $request->get('kw');
        if ($kw) $sql = $sql->where('name', 'like', '%' . $kw . '%');
        $total = $sql->count();
        $pagesize = isset($this->site['SITE_ADMIN_PAGESIZE']) && $this->site['SITE_ADMIN_PAGESIZE'] ? $this->site['SITE_ADMIN_PAGESIZE'] : 8;
        $url = url('admin/relatedlink/index') . '?page={page}&kw=' . $kw;

        $data = $sql->offset(($page - 1) * $pagesize)->limit($pagesize)->orderBy('sort', 'DESC')->orderBy('id', 'DESC')->get()->toArray();
        $pagelist = $pagelist->total($total)->url($url)->num($pagesize)->page($page)->output();

        $this->assign(array(
            'list' => $data,
            'pagelist' => $pagelist,
        ));
        return $this->display('admin/relatedlink_list');
    }

    public function addAction(Request $request)
    {
        if ($request->method() === 'POST' && $request->get('submit')) {
            $data = $request->get('data');
            if (empty($data['name']) || empty($data['url'])) return $this->adminMsg(lang('a-tag-12'));
            if (!check::is_url($data['url'])) return $this->adminMsg(lang('a-tag-13'));
            $data['sort'] = intval($data['sort']);

            $this->relatedlink->create($data);

            return $this->adminMsg($this->getCacheCode('admin/relatedlink/cache') . lang('success'), url('admin/relatedlink'), 3, 1, 1);
        }

        return $this->display('admin/relatedlink_add');
    }

    public function editAction(Request $request, $id)
    {
        $data = $this->relatedlink->find($id);
        if (empty($data)) return $this->adminMsg(lang('a-tag-14'));

        if ($request->method() === 'POST' && $request->get('submit')) {
            $data = $request->get('data');
            if (empty($data['name']) || empty($data['url'])) return $this->adminMsg(lang('a-tag-12'));
            if (!check::is_url($data['url'])) return $this->adminMsg(lang('a-tag-13'));

            $this->relatedlink->where('id', $id)->update($data);

            return $this->adminMsg($this->getCacheCode('admin/relatedlink/cache') . lang('success'), url('admin/relatedlink'), 3, 1, 1);
        }

        $this->assign('data', $data);
        return $this->display('admin/relatedlink_add');
    }

    public function delAction($id = 0, $all = 0)
    {
        if (!auth::check($this->roleid, 'relatedlink-del', 'admin')) return $this->adminMsg(lang('a-com-0', array('1' => 'relatedlink', '2' => 'del')));

        $this->relatedlink->where('id', $id)->delete();

        return $all ? '' : $this->adminMsg($this->getCacheCode('admin/relatedlink/cache') . lang('success'), url('admin/relatedlink/index'), 3, 1, 1);
    }

    public function importAction(Request $request)
    {
        if ($request->method() === 'POST' && $request->get('submit')) {
            $i = $j = $k = 0;
            $file = $_FILES['txt'];

            if ($file['type'] != 'text/plain') return $this->adminMsg(lang('a-tag-3', array('1' => $file['type'])));
            if ($file['error']) return $this->adminMsg(lang('a-tag-4'));
            if (!file_exists($file['tmp_name'])) return $this->adminMsg(lang('a-tag-5'));

            $data = file_get_contents($file['tmp_name']);
            $data = explode(PHP_EOL, $data);

            foreach ($data as $t) {
                $t = explode(' ', trim($t));
                $name = trim($t[0]);
                $url = trim($t[count($t) - 1]);
                if ($name && check::is_url($url)) {
                    $row = $this->relatedlink->where('name', $name)->get()->first();
                    if (empty($row)) {
                        $id = $this->relatedlink->create(array('name' => $name, 'url' => $url));
                        if ($id) $i++;
                    } else {
                        $j++;
                    }
                } else {
                    $k++;
                }
            }

            return $this->adminMsg($this->getCacheCode('admin/relatedlink/cache') . lang('a-tag-6', array('1' => $i, '2' => $k, '3' => $j)), url('admin/relatedlink/index'), 3, 1, 1);
        }

        return $this->display('admin/relatedlink_import');
    }

    public function cacheAction($show = 0)
    {
        $data = $this->relatedlink->orderBy('sort', 'DESC')->where('id', 'DESC')->get()->toArray();
        $list = array();
        if ($data) {
            foreach ($data as $t) {
                $list[$t['name']] = $t;
            }
        }

        $this->cache->set('relatedlink', $list);
        return $show ? '' : $this->adminMsg(lang('a-update'), url('admin/relatedlink'), 3, 1, 1);
    }
}