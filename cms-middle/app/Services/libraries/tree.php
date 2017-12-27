<?php

namespace App\Services\libraries;

class tree
{
    private $parentid;
    private $id;
    private $name;
    private $data;

    public function __construct()
    {

        $this->parentid = 'parent_id';
        $this->id = 'id';
        $this->name = 'name';

        return true;
    }

    public function config($params)
    {
        if (!$params || !is_array($params)) return false;

        $this->parentid = (isset($params['parent_id'])) ? $params['parent_id'] : $this->parentid;
        $this->id = (isset($params['id'])) ? $params['id'] : $this->id;
        $this->name = (isset($params['name'])) ? $params['name'] : $this->name;

        return $this;
    }

    // 生成树select的option
    public function get_tree($data, $parent_id = 0, $select_id = null, $pre_fix = '|-', $child = false, $groupid = null, $roleid = null)
    {
        if (!$data || !is_array($data)) return '';

        $string = '';
        foreach ($data as $key => $value) {
            if ($child && $value['child'] == 0) continue;

            if ($value[$this->parentid] == $parent_id) {
                $str = '<option value=\'' . $value[$this->id] . '\'';
                if (!is_null($select_id)) {
                    $str .= ($value[$this->id] == $select_id) ? ' selected="selected"' : '';
                }

                if ($child && $value['child'] == 1) {
                    $str .= ' disabled';

                } elseif ($groupid && isset($value['setting']['memberpost']) && $value['setting']['memberpost'] && $value['setting']['grouppost'] && in_array($groupid, $value['setting']['grouppost'])) {
                    //会员权限判断
                    if ($value['child'] == 0) continue;
                    $str .= ' disabled';

                } elseif ($roleid && isset($value['setting']['adminpost']) && $value['setting']['adminpost'] && @in_array($roleid, $value['setting']['rolepost'])) {
                    if ($value['child'] == 0) continue;
                    $str .= ' disabled';
                }

                $string .= $str . '>' . ($value['parentid'] == 0 ? '' : $pre_fix) . $value[$this->name] . '</option>';
                $string .= $this->get_tree($data, $value[$this->id], $select_id, '&nbsp;&nbsp;' . $pre_fix, $child, $groupid, $roleid);
            }
        }

        return $string;
    }

    // 获取模型的select的option树
    public function get_model_tree($data, $parent_id = 0, $select_id = null, $pre_fix = '|-', $modelid, $_modelid = null, $_groupid = null, $_roleid = null)
    {
        if (!$data || !is_array($data)) return '';

        $string = '';
        foreach ($data as $key => $value) {
            if ($value['typeid'] == 3 || ($value['arrmodelid'] && !in_array($modelid, $value['arrmodelid']))) continue;
            if ($value[$this->parentid] == $parent_id) {
                $str = '<option value=\'' . $value[$this->id] . '\'';
                if (!is_null($select_id)) $str .= ($value[$this->id] == $select_id) ? ' selected="selected"' : '';
                if ($value['child'] == 1) {
                    $str .= ' disabled';
                } elseif (($_modelid || $_groupid) && isset($value['setting']['memberpost']) && $value['setting']['memberpost']) {
                    //会员权限判断v1.6
                    if ($value['setting']['modelpost'] && in_array($_modelid, $value['setting']['modelpost'])) {
                        if ($value['child'] == 0) continue;
                        $str .= ' disabled';
                    } elseif ($value['setting']['grouppost'] && in_array($_groupid, $value['setting']['grouppost'])) {
                        if ($value['child'] == 0) continue;
                        $str .= ' disabled';
                    }
                } elseif ($_roleid && isset($value['setting']['adminpost']) && $value['setting']['adminpost'] && @in_array($_roleid, $value['setting']['rolepost'])) {
                    //if ($value['child'] == 0) continue;
                    $str .= ' disabled';
                }
                $string .= $str . '>' . ($value['parentid'] == 0 ? '' : $pre_fix) . $value[$this->name] . '</option>';

                $string .= $this->get_model_tree($data, $value[$this->id], $select_id, '&nbsp;&nbsp;' . $pre_fix, $modelid, $_modelid, $_groupid, $_roleid);
            }
        }
        return $string;
    }

    //
    public function get_tree_data($data, $parent_id = 0, $pre_fix = '|-')
    {
        if (!$data || !is_array($data)) return '';

        foreach ($data as $key => $value) {
            if ($value[$this->parentid] == $parent_id) {
                $this->data[$key] = $value;
                $this->data[$key]['prefix'] = $pre_fix . $value[$this->name];

                $this->get_tree_data($data, $value[$this->id], '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $pre_fix);
            }
        }

        return $this->data;
    }

    // 获取子类
    public function get_child($data, $id)
    {
        if (!$data || !is_array($data)) return array();
        $temp_array = array();
        foreach ($data as $value) {
            if ($value[$this->parentid] == $id) {
                $temp_array[] = $value;
            }
        }
        return $temp_array;
    }

    // 获取父类
    public function get_parent($data, $id)
    {
        if (!$data || !is_array($data)) return array();
        $temp = array();
        foreach ($data as $vaule) {
            $temp[$vaule[$this->id]] = $vaule;
        }
        $parentid = $temp[$id][$this->parentid];
        return $temp[$parentid];
    }

}