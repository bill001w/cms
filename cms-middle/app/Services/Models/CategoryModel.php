<?php

namespace App\Services\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryModel extends Model
{
    use ModelTrait;

    public $timestamps = false;
    protected $table;
    protected $primaryKey;
    protected $guarded = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->table = $this->prefix . 'category';
        $this->primaryKey = 'catid';
    }

    public function getData()
    {
        return $this->orderBy('listorder', 'ASC')
            ->orderBy('catid', 'ASC')
            ->get()
            ->toArray();
    }

    public function check_catdir($catid = 0, $catdir)
    {
        if (empty($catdir)) {
            return TRUE;
        }
        $sql = $this->where('catdir', $catdir);
        if ($catid) {
            $sql = $sql->where('catid', '<>', $catid);
        }
        $data = $sql->get()->toArray();
        return empty($data) ? FALSE : TRUE;
    }

    public function repair($parentid = 0)
    {
        $data = $this->where('parentid', $parentid)->orderBy('listorder', 'ASC')->get()->toArray();
        foreach ($data as $t) {
            //检查该栏目下是否有子栏目
            $catid = $t['catid'];
            $parentid = $t['parentid'];
            //当前栏目的所有父栏目ID(arrparentid)
            $arrparentid = array();
            foreach ($data as $s) {
                $arrparentid[] = $s['catid'];
            }
            //组合父栏目ID
            $arrparentid = implode(',', $arrparentid);

            //查询子栏目
            $s_data = $this->where('parentid', $t['catid'])->orderBy('listorder', 'ASC')->get()->toArray();
            //存在子栏目
            if ($s_data) {
                //当前栏目的所有子栏目ID($arrchildid)
                $arrchildid = array();
                foreach ($s_data as $s) {
                    $arrchildid[] = $s['catid'];
                }
                //组合子栏目ID
                $arrchildid = implode(',', $arrchildid);

                $this->where('catid', $catid)
                    ->update(array('child' => 1, 'arrchildid' => $arrchildid, 'arrparentid' => $arrparentid));
                $this->repair($catid); //递归调用
            } else {
                //没有子栏目
                $this->where('catid', $catid)
                    ->update(array('child' => 0, 'arrchildid' => '', 'arrparentid' => $arrparentid));
            }
        }
    }

    public function child($catid, $parent = false, $typeid = 0)
    {
        $str = '';
        $data = $this->find($catid);
        if (empty($data)) {
            return false;
        }
        if ($data['child'] && $data['arrchildid']) { //存在子栏目
            if ($parent && ($typeid ? $typeid == $data['typeid'] : true)) {
                $str .= $catid . ',';
            }
            $ids = array();
            $arrchildid = $data['arrchildid'];
            if ($arrchildid) {
                $ids = explode(',', $arrchildid);
            }
            foreach ($ids as $id) {
                $str .= $this->child($id, $parent, $typeid);
            }
        } else {
            if ($typeid ? $typeid == $data['typeid'] : true) {
                $str .= $catid . ',';
            }
        }
        return $str;
    }

    public function getParentData($catid)
    {
        $cat = $this->find($catid);
        if ($cat['parentid']) {
            $cat = $this->getParentData($cat['parentid']);
        }
        return $cat;
    }
}