<?php

namespace App\Services\Models;

use DB;
use Illuminate\Support\Facades\Schema;

trait ModelTrait
{
    protected $prefix = 'fn_';

    public function is_table_exists($table)
    {
        return Schema::hasTable($table);
    }

    public function get_tables()
    {
        $tables = collect(DB::statement('SHOW TABLES'))->pluck('Tables_in_m-cms')->toArray();

        return $tables;
    }
}