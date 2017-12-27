<?php

namespace App\Services\Models;

use Illuminate\Database\Eloquent\Model;

class ModelModel extends Model
{
    use ModelTrait;

    public $timestamps = false;
    protected $table;
    protected $primaryKey;
    protected $guarded = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->table = $this->prefix . 'model';
        $this->primaryKey = 'modelid';
    }

    public function get_data()
    {
        return $this->all()->toArray();
    }

    public function set($modelid = 0, $data)
    {
        //修改模型
        if ($modelid) {
            $this->where('modelid', $modelid)
                ->update($data);

            return $modelid;
        }

        // 添加模型
        $model = $this->create($data);

        return $model['modelid'];
    }

    public function del($data)
    {
        $this->where('modelid', $data['modelid'])
            ->delete();

        \DB::delete('DELETE FROM `' . $this->prefix . 'content` where modelid=?', [$data['modelid']]);
    }

}