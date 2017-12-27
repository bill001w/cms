<?php

namespace App\Services\Models;

use Illuminate\Database\Eloquent\Model;

class PositionModel extends Model
{
    use ModelTrait;

    public $timestamps = false;
    protected $table;
    protected $primaryKey;
    protected $guarded = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->table = $this->prefix . 'position';
        $this->primaryKey = 'posid';
    }

    public function set($posid, $data)
    {
        if ($posid) {
            $this->where('posid', $posid)
                ->update($data);

            return true;
        }

        $result = $this->create($data);

        if ($result->posid) return true;
        return false;
    }

    public function del($posid)
    {
        $this->where('posid', $posid)
            ->delete();

        $table = $this->prefix . 'position_data';
        \DB::delete('delete from ' . $table . ' where posid=?', [$posid]);
    }
}