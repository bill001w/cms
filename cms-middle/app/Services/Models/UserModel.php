<?php

namespace App\Services\Models;

use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    use ModelTrait;

    public $timestamps = false;
    protected $table;
    protected $primaryKey;
    protected $guarded = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->table = $this->prefix . 'user';
        $this->primaryKey = 'uid';
    }

    public function check_login($request, $username, $password)
    {
        $row = $this->where('username', $username)
            ->first();

        if ($row) {
            if (md5(md5($password) . $row['salt'] . md5($password)) != $row->password) return false;

            $ip = $request->ip();
            if (empty($row->loginip) || $row->loginip != $ip) {
                $update = array(
                    'lastloginip' => $row->loginip,
                    'lastlogintime' => (int)$row->logintime,
                    'loginip' => $ip,
                    'logintime' => time(),
                );

                $this->where('uid', $row->uid)
                    ->update($update);
            }

            return $row;
        }

        return false;
    }

    public function get_user_list($roleid = NULL, $admin = 0)
    {
        return $this->leftJoin($this->prefix . 'role', function ($join) use($roleid){
            $join->on($this->prefix . 'user.roleid', '=', $this->prefix . 'role.roleid')
                ->where($this->prefix . 'user.roleid', '=', $roleid);
        })
            ->get()
            ->toArray();
    }
}