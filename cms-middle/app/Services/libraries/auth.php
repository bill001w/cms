<?php

namespace App\Services\libraries;

class auth
{
    public static function check($groupid, $action = null, $namespace = "defalut")
    {
        if ($groupid == 1) {
            return true;
        }

        if (!$action) {
            $route_name = explode('/', \Route::currentRouteName());
            $namespace = $route_name[0];
            $action = $route_name[1] . '-' . $route_name[2];
        }

        $action = strtolower($action);
        $namespace = strtolower($namespace);

        if (self::skip($action, $namespace)) {
            return true;
        }

        $rules = self::get_role($groupid);
        if (empty($rules)) {
            false;
        }
        list($c, $m) = explode("-", $action);
        if (@in_array($c, $rules)) {
            return true;
        } elseif (@in_array($action, $rules)) {
            return true;
        } else {
            return false;
        }
    }

    public static function get_role($groupid)
    {
        $config_file = CONFIG_DIR . "auth.role.ini.php";
        if (!is_file($config_file)) {
            return null;
        }
        $config = require $config_file;
        return $groupid && isset($config[$groupid]) ? $config[$groupid] : null;
    }

    public static function skip($action, $namespace = "defalut")
    {
        list($c, $m) = explode("-", $action);
        if (stripos($m, "ajax") !== false) {
            return true;
        }

        $config_file = CONFIG_DIR . "auth.skip.ini.php";
        if (!is_file($config_file)) {
            return false;
        }
        $config = require $config_file;
        $skip = $namespace && isset($config[$namespace]) ? $config[$namespace] : $config['defalut'];
        if (empty($skip)) {
            return true;
        }
        if (in_array($c, $skip)) {
            return true;
        } elseif (in_array($action, $skip)) {
            return true;
        } else {
            return false;
        }
    }

}