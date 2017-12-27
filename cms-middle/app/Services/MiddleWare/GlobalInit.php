<?php

namespace App\Services\Middleware;

use App\Services\Core\Basic;
use App\Services\Core\Lang;
use Closure;

class GlobalInit
{
    public function handle($request, Closure $next)
    {
        error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_STRICT);

        define('APP_ROOT', app_path('Services') . DIRECTORY_SEPARATOR);
        $config = require APP_ROOT . 'Config/config.ini.php';

        //设置程序开始执行时间
        define('SYS_START_TIME', microtime(true));
        define('VIEW_DIR', APP_ROOT . 'views' . DIRECTORY_SEPARATOR);
        define('SYS_THEME_DIR', VIEW_DIR . $config['SITE_THEME'] . DIRECTORY_SEPARATOR);
        define('ADMIN_THEME', VIEW_DIR . '/admin/');

        define('CMS_NAME', $config['SITE_NAME']);
        define('SITE_TITLE', $config['SITE_TITLE']);
        define('SITE_KEYWORDS', $config['SITE_KEYWORDS']);
        define('SITE_DESCRIPTION', $config['SITE_DESCRIPTION']);
        define('SITE_ICP', $config['SITE_ICP']);
        if ($config['SITE_JS']) {
            $config['SITE_JS'] = html_entity_decode(str_replace('{|}', "'", string2array($config['SITE_JS']['value'])));
        }

        //时区
        define('SYS_TIME_ZONE', 'Etc/GMT' . ($config['SITE_TIMEZONE'] > 0 ? '-' : '+') . (abs($config['SITE_TIMEZONE'])));
        date_default_timezone_set(SYS_TIME_ZONE);
        //输出时间格式化
        define('TIME_FORMAT', isset($config['SITE_TIME_FORMAT']) && $config['SITE_TIME_FORMAT'] ? $config['SITE_TIME_FORMAT'] : 'Y-m-d H:i:s');
        //网站语言设置
        define('SYS_LANGUAGE', isset($config['SITE_LANGUAGE']) && $config['SITE_LANGUAGE'] ? $config['SITE_LANGUAGE'] : 'zh-cn');
        //网站语言文件
        define('LANGUAGE_DIR', APP_ROOT . 'Language' . DIRECTORY_SEPARATOR . SYS_LANGUAGE . DIRECTORY_SEPARATOR);
        if (!file_exists(LANGUAGE_DIR)) {
            exit('语言目录不存在：' . LANGUAGE_DIR);
        }
        $language = require LANGUAGE_DIR . 'lang.php';
        if (file_exists(LANGUAGE_DIR . 'custom.php')) {
            $custom_lang = require LANGUAGE_DIR . 'custom.php';
            $language = array_merge($language, $custom_lang);
        }
        // todo 禁止访问--------
        Basic::$config = $config;
        Basic::$language = $language;
        Basic::$lang = new Lang();

        \DB::setFetchMode(\PDO::FETCH_ASSOC);

        return $next($request);
    }
}

