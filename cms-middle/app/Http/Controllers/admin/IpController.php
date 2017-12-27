<?php

namespace App\Http\Controllers\admin;

use App\Services\dayrui\libraries\pagelist;
use App\Services\libraries\auth;
use App\Services\Models\IpModel;
use Illuminate\Http\Request;

class IpController extends Admin
{
    private $ip;

    public function __construct(Request $request)
    {
        parent::__construct($request);

        $this->ip = new IpModel();
    }

    public function indexAction(Request $request)
    {
        if ($request->method() === 'POST' && $request->get('submit_del')) {
            foreach ($request->all() as $var => $value) {
                if (strpos($var, 'del_') !== false) {
                    $id = (int)str_replace('del_', '', $var);

                    $this->ip->where('id', $id)
                        ->delete();
                }
            }

            return $this->adminMsg($this->getCacheCode('ip') . lang('success'), url('admin/ip/'), 3, 1, 1);
        }

        $ip = $request->get('kw') ? $request->get('kw') : $request->get('ip');
        $page = (int)$request->get('page');
        $page = (!$page) ? 1 : $page;

        $pagelist = new pagelist();
        $pagelist->loadconfig();
        $total = $ip ? $this->ip->where('ip', 'LIKE', '%' . $ip . '%')->count() : $this->ip->count();
        $pagesize = isset($this->site['SITE_ADMIN_PAGESIZE']) && $this->site['SITE_ADMIN_PAGESIZE'] ? $this->site['SITE_ADMIN_PAGESIZE'] : 8;
        $url = url('admin/ip/index') . '?page={page}&ip=' . $ip;
        $select = $this->ip->limit($page, $pagesize)->orderBy('id', 'DESC');
        $data = $ip ? $select->where('ip', 'LIKE', '%' . $ip . '%')->select() : $select->get()->toArray();
        $pagelist = $pagelist->total($total)->url($url)->num($pagesize)->page($page)->output();

        $this->assign(array(
            'list' => $data,
            'pagelist' => $pagelist,
        ));
        return $this->display('admin/ip_list');
    }

    public function addAction(Request $request)
    {
        if ($request->method() === 'POST' && $request->get('submit')) {
            $data = $request->get('data');
            if (empty($data['ip'])) return $this->adminMsg(lang('a-aip-0'));

            if ($this->ip->where('ip', $data['ip'])->first()) return $this->adminMsg(lang('a-aip-8'));

            $data['addtime'] = time();
            $this->ip->create($data);

            return $this->adminMsg($this->getCacheCode('ip') . lang('success'), url('admin/ip'), 3, 1, 1);
        }

        return $this->display('admin/ip_add');
    }

    public function cacheAction($show = 0)
    {
        $list = $this->ip->findAll();
        $data = array();
        foreach ($list as $t) {
            if (empty($t['endtime']) || ($t['endtime'] - $t['addtime']) >= 0) $data[$t['ip']] = $t;
        }

        $this->cache->set('ip', $data);

        return $show ? '' : $this->adminMsg(lang('a-update'), '', 3, 1, 1);
    }
}