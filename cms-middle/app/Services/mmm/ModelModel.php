<?php

namespace App\Services\models;

class ModelModel extends Model
{
    public function get_primary_key()
    {
        return $this->primary_key = 'modelid';
    }

    //获取模型数据
    public function get_data()
    {
        return $this->select();
    }

    //添加和修改模型
    public function set($modelid = 0, $data)
    {
        //修改模型
        if ($modelid) {
            $this->update($data, 'modelid=' . $modelid);
            return $modelid;
        }

        // 添加模型
        $this->insert($data);
        $modelid = $this->get_insert_id();
        if (empty($modelid)) return false;
        return $modelid;
    }

    //删除模型
    public function del($data)
    {
        $this->query('DELETE FROM `' . $this->prefix . 'model` where modelid=' . $data['modelid']);
        $this->query('DELETE FROM `' . $this->prefix . 'content` where modelid=' . $data['modelid']);
    }
}