<?php

namespace App\Http\Controllers\admin;

use App\Services\libraries\auth;
use App\Services\libraries\tree;
use App\Services\Models\RoleModel;
use Illuminate\Http\Request;

class CategoryController extends Admin
{
    private $tree;
    private $role;

    public function __construct(Request $request)
    {
        parent::__construct($request);

        $this->tree = new tree();
        $this->tree->config(array('id' => 'catid', 'parent_id' => 'parentid', 'name' => 'catname'));
        $this->role = new RoleModel();
    }

    public function indexAction(Request $request)
    {
        if ($request->method() === 'POST' && $request->get('submit')) {
            foreach ($request->all() as $var => $value) {
                if (strpos($var, 'order_') !== false) {
                    $this->category
                        ->where('catid', (int)str_replace('order_', '', $var))
                        ->update(['listorder' => $value]);
                }
            }

            return $this->adminMsg($this->getCacheCode('admin/category/cache') . lang('success'), url('admin/category/index'), 3, 1, 1);
        }

        if ($request->method() === 'POST' && $request->get('delete')) {
            $ids = $request->get('ids');
            if ($ids) {
                foreach ($ids as $catid) {
                    $this->delAction($catid, 1);
                }
            }

            return $this->adminMsg($this->getCacheCode('admin/category/cache') . lang('success'), url('admin/category/index'), 3, 1, 1);
        }

        $data = $this->category->getData();

        $this->assign(array(
            'list' => $this->tree->get_tree_data($data)
        ));
        return $this->display('admin/category_list');
    }

    public function addAction(Request $request)
    {
        if ($request->method() === 'POST' && $request->get('submit')) {
            $data = $request->get('data');

            if ($request->get('addall')) {
                $names = $request->get('names');
                if (empty($names)) {
                    return $this->adminMsg(lang('a-cat-4'));
                }

                $names = explode(PHP_EOL, $names);
                $y = $n = 0;
                foreach ($names as $val) {
                    list($catname, $catdir) = explode('|', $val);
                    $catdir = $catdir ? $catdir : word2pinyin($catname);
                    if ($this->category->check_catdir(0, $catdir)) {
                        $catdir .= rand(0, 9);
                    }
                    $data['catdir'] = $catdir;
                    $data['catname'] = $catname;
                    $data['setting'] = $request->get('setting');

                    $catid = $this->category->create($data);
                    if (!is_numeric($catid)) {
                        $n++;
                    } else {
                        $y++;
                    }
                }

                return $this->adminMsg($this->getCacheCode('admin/category/cache') . lang('a-cat-5', array('1' => $y, '2' => $n)), url('admin/category/index'), 3, 1, 1);
            } else {
                if (empty($data['catname'])) {
                    return $this->adminMsg(lang('a-cat-4'));
                }
                if ($this->category->check_catdir(0, $data['catdir'])) {
                    return $this->adminMsg(lang('a-cat-6'));
                }
                $data['setting'] = $request->get('setting');

                $result = $this->category->create($data);
                dd($result);
                if (!$result) {
                    return $this->adminMsg('添加失败');
                }

                $data['catid'] = $result;

                return $this->adminMsg($this->getCacheCode('admin/category/cache') . lang('success'), url('admin/category/index'), 3, 1, 1);
            }
        }

        $catid = (int)$request->get('catid');
        $model = $this->cache->get('model');

        $this->assign(array(
            'add' => 1,
            'model' => $model,
            'rolemodel' => $this->role->get_role_list(),
            'membergroup' => $this->cache->get('membergroup'),
            'membermodel' => $this->membermodel,
            'category_select' => $this->tree->get_tree($this->cats, 0, $catid)
        ));
        return $this->display('admin/category_add');
    }

    public function editAction(Request $request, $catid)
    {
        if ($request->method() === 'POST' && $request->get('submit')) {
            if (empty($catid)) {
                return $this->adminMsg(lang('a-cat-7'));
            }

            $data = $request->get('data');
            if (empty($data['catname'])) {
                return $this->adminMsg(lang('a-cat-4'));
            }

            if ($this->category->check_catdir($catid, $data['catdir'])) {
                return $this->adminMsg(lang('a-cat-6'));
            }
            $data['setting'] = $request->get('setting');
            $result = $this->category->where('catid', $catid)
                ->update($data);

            if (!$result) {
                $data['catid'] = $catid;
                return $this->adminMsg($this->getCacheCode('admin/category/cache') . lang('success'), url('admin/category/edit', array('catid' => $catid)), 3, 1, 1);
            } else {
                return $this->adminMsg(lang('a-cat-8'));
            }
        }

        if (empty($catid)) {
            return $this->adminMsg(lang('a-cat-7'));
        }
        if (!isset($this->cats[$catid])) {
            return $this->adminMsg(lang('m-con-9', array('1' => $catid)));
        }
        $data = $this->category->find($catid);
        $model = $this->cache->get('model');

        $this->assign(array(
            'data' => $data,
            'model' => $model,
            'catid' => $catid,
            'setting' => string2array($data['setting']),
            'rolemodel' => $this->role->get_role_list(),
            'membergroup' => $this->cache->get('membergroup'),
            'membermodel' => $this->membermodel,
            'category_select' => $this->tree->get_tree($this->cats, 0, $data['parentid'])
        ));
        return $this->display('admin/category_add');
    }

    public function delAction($catid = 0, $all = 0)
    {
        if (!auth::check($this->roleid, 'category/del', 'admin')) {
            return $this->adminMsg(lang('a-com-0', array('1' => 'category', '2' => 'del')));
        }

        $all = $all ? $all : $this->get('all');
        if (empty($catid)) {
            return $this->adminMsg(lang('a-cat-7'));
        }
        if (!isset($this->cats[$catid])) {
            return $this->adminMsg(lang('m-con-9', array('1' => $catid)));
        }

        $result = $this->category
            ->where('catid', $catid)
            ->delete();

        if ($result) {
            return $all ? '' : $this->adminMsg($this->getCacheCode('admin/category/cache') . lang('success'), url('admin/category/index'), 3, 1, 1);
        } else {
            return $all ? '' : $this->adminMsg(lang('a-cat-8'));
        }
    }

    public function cacheAction($show = 0)
    {
        //递归修复栏目数据
        $this->category->repair();

        $data = $this->category->getData();
        $category = $category_dir = $count = array();
        foreach ($data as $t) {
            $catid = $t['catid'];
            $category[$catid] = $t;

            //所有子栏目集,默认当前栏目ID
            $category[$catid]['arrchilds'] = $catid;
            if ($t['child']) {
                $category[$catid]['arrchilds'] = $this->category->child($catid) . $catid;
            }

            //统计数据
            $count[$catid]['items'] = $this->content
                ->whereIn('catid', explode(',', $category[$catid]['arrchilds']))
                ->where('status', '<>', 0)
                ->count();

            $category[$catid]['items'] = $count[$catid]['items'];
            $this->category->where('catid', $catid)
                ->update(array('items' => $count[$catid]['items']));

            //转换setting
            $category[$catid]['setting'] = string2array($category[$catid]['setting']);

            //更新分页数量
            if (empty($t['pagesize'])) {
                $pcat = $this->category->getParentData($catid);
                $category[$catid]['pagesize'] = $pcat['pagesize'] ? $pcat['pagesize'] : $this->site['SITE_SEARCH_PAGE'];
                $this->category->where('catid', $catid)
                    ->update(array('pagesize' => $category[$catid]['pagesize']));
            }

            $category_dir[$t['catdir']] = $t['catid'];
        }

        $this->cache->set('category', $category);
        $this->cache->set('category_dir', $category_dir);

        return $show ? '' : $this->adminMsg(lang('a-update'), url('admin/category/index'), 3, 1, 1);
    }
}