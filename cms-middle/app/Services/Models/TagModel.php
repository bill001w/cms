<?php

namespace App\Services\Models;

use Illuminate\Database\Eloquent\Model;

class TagModel extends Model
{
    use ModelTrait;

    public $timestamps = false;
    protected $table;
    protected $primaryKey;
    protected $guarded = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->table = $this->prefix . 'tag';
        $this->primaryKey = 'id';
    }
}