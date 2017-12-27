<?php

namespace App\Services\Models;

use Illuminate\Database\Eloquent\Model;

class RoleModel extends Model
{
    use ModelTrait;

    public $timestamps = false;
    protected $table;
    protected $primaryKey;
    protected $guarded = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->table = $this->prefix . 'role';
        $this->primaryKey = 'roleid';
    }

    public function get_role_list()
    {
        return $this->orderBy('roleid', 'asc')
            ->get()
            ->toArray();
    }
}