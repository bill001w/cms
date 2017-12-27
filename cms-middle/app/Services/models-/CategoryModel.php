<?php

namespace App\Services\models;

class CategoryModel extends Model
{
    public function get_primary_key()
    {
        return $this->primary_key = 'catid';
    }

    public function getData()
    {
        return $this->order('listorder ASC,catid ASC')->select();
    }

    public function set($catid, $data)
    {
        unset($data['catid']);

        if ($catid) {
            if ($data['synpost']) {
                //同步子栏目
                $childs = $this->child($catid);
                $childs = explode(',', $childs);
                if (count($childs) > 2) {
                    foreach ($childs as $id) {
                        if (empty($id) || $id == $catid) {
                            continue;
                        }

                        $cdata = $this->find($id);
                        $cset = string2array($cdata['setting']);
                        $cset['memberpost'] = $data['setting']['memberpost'];
                        $cset['modelpost'] = $data['setting']['modelpost'];
                        $cset['adminpost'] = $data['setting']['adminpost'];
                        $cset['rolepost'] = $data['setting']['rolepost'];
                        $cset['grouppost'] = $data['setting']['grouppost'];
                        $cset['guestpost'] = $data['setting']['guestpost'];
                        $cset['verifypost'] = $data['setting']['verifypost'];
                        $cset['verifyrole'] = $data['setting']['verifyrole'];

                        $this->update(array('setting' => array2string($cset)), 'catid=' . $id);
                    }
                }
            }

            unset($data['synpost']);
            $data['setting'] = array2string($data['setting']);

            $this->update($data, 'catid=' . $catid);
            $this->repair();

            return $catid;

        } else {
            //继承父栏目权限配置
            if (!empty($data['parentid']) && empty($data['child'])) {
                $pdata = $this->find($data['parentid']);
                $pset = string2array($pdata['setting']);

                $data['setting']['memberpost'] = $data['setting']['memberpost'] ? $data['setting']['memberpost'] : ($pset['memberpost'] ? $pset['memberpost'] : null);
                $data['setting']['modelpost'] = $data['setting']['modelpost'] ? $data['setting']['modelpost'] : ($pset['modelpost'] ? $pset['modelpost'] : null);
                $data['setting']['adminpost'] = $data['setting']['adminpost'] ? $data['setting']['adminpost'] : ($pset['adminpost'] ? $pset['adminpost'] : null);
                $data['setting']['rolepost'] = $data['setting']['rolepost'] ? $data['setting']['rolepost'] : ($pset['rolepost'] ? $pset['rolepost'] : null);
                $data['setting']['grouppost'] = $data['setting']['grouppost'] ? $data['setting']['grouppost'] : ($pset['grouppost'] ? $pset['grouppost'] : null);
                $data['setting']['guestpost'] = $data['setting']['guestpost'] ? $data['setting']['guestpost'] : ($pset['guestpost'] ? $pset['guestpost'] : null);
                $data['setting']['verifypost'] = $data['setting']['verifypost'] ? $data['setting']['verifypost'] : ($pset['verifypost'] ? $pset['verifypost'] : null);
                $data['setting']['verifyrole'] = $data['setting']['verifyrole'] ? $data['setting']['verifyrole'] : ($pset['verifyrole'] ? $pset['verifyrole'] : null);
                unset($pdata, $pset);
            }

            $data['pagesize'] = (int)$data['pagesize'];
            unset($data['synpost']);
            $data['setting'] = array2string($data['setting']);
            $data['child'] = 0;
            $data['arrchildid'] = '';
            $data['arrparentid'] = '';

            $this->insert($data);
        }

        $catid = $this->get_insert_id();

        $this->repair();

        return empty($catid) ? lang('failure') : $catid;
    }

    public function del($catid)
    {
        if (empty($catid)) {
            return false;
        }

        $this->repair($catid);

        $catids = $this->child($catid, true);
        if (empty($catids)) {
            return false;
        }
        $catids = trim($catids, ',');
        $this->delete('catid IN (' . $catids . ')');

        $tableName = $this->execute('SELECT `tablename` FROM `' . $this->prefix . 'model` WHERE `modelid` in (select `modelid` from `' . $this->prefix . 'content` where `catid` IN (' . $catids . '))');
        if ($tableName) {
            foreach ($tableName as $t) {
                $this->query('DELETE FROM `' . $this->prefix . $t . '` WHERE `catid` IN (' . $catids . ')');
            }
        }

        $this->query('DELETE FROM `' . $this->prefix . 'content` WHERE `catid` IN (' . $catids . ')');

        return true;
    }

    /**
     * 递归查找所有子栏目ID
     * @param int $catid
     * @param boolean $parent
     * @param int $typeid
     * @return string
     */
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

    /**
     * 递归修复所有栏目的子类id和同级分类id
     * @param int $parentid
     */
    public function repair($parentid = 0)
    {
        $data = $this->where('parentid=' . $parentid)->order('listorder ASC')->select();
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
            $s_data = $this->where('parentid=?', $t['catid'])->order('listorder ASC')->select();
            //存在子栏目
            if ($s_data) {
                //当前栏目的所有子栏目ID($arrchildid)
                $arrchildid = array();
                foreach ($s_data as $s) {
                    $arrchildid[] = $s['catid'];
                }
                //组合子栏目ID
                $arrchildid = implode(',', $arrchildid);
                $this->update(array('child' => 1, 'arrchildid' => $arrchildid, 'arrparentid' => $arrparentid), 'catid=' . $catid);
                $this->repair($catid); //递归调用
            } else {
                //没有子栏目
                $this->update(array('child' => 0, 'arrchildid' => '', 'arrparentid' => $arrparentid), 'catid=' . $catid);
            }
        }
    }

    /**
     * 验证栏目路径是否存在
     * @param int $catid
     * @param string $catdir
     * @return boolean
     */
    public function check_catdir($catid = 0, $catdir)
    {
        if (empty($catdir)) {
            return TRUE;
        }
        $this->where('catdir=?', $catdir);
        if ($catid) {
            $this->where('catid<>?', $catid);
        }
        $data = $this->select(false);
        return empty($data) ? FALSE : TRUE;
    }

    /**
     * 递归查询所有父级栏目信息
     * @param  int $catid 当前栏目ID
     * @return array
     */
    public function getParentData($catid)
    {
        $cat = $this->find($catid);
        if ($cat['parentid']) {
            $cat = $this->getParentData($cat['parentid']);
        }
        return $cat;
    }

    /**
     * 递归设置栏目所有子栏目组
     */
    public function setChildData($parentid, $data)
    {
        foreach ($data as $catid => $t) {
            if ($t['child']) {
                $data[$catid]['arrchilds'] = $this->getArrchildid($t['catid'], $data);
            }
        }
        return $data;
    }

    /**
     * 获取子栏目ID列表
     */
    private function getArrchildid($catid, $data)
    {
        $arrchildid = $catid;
        foreach ($data as $m) {
            if ($m['catid'] != $catid && $m['parentid'] == $catid) {
                $arrchildid .= ',' . $this->getArrchildid($m['catid'], $data);
            }
        }
        return $arrchildid;
    }
}