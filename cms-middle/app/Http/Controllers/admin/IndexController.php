<?php

namespace App\Http\Controllers\admin;

use App\Services\dayrui\libraries\file_list;
use App\Services\dayrui\libraries\pagelist;
use Illuminate\Http\Request;

class IndexController extends Admin
{
    public function indexAction()
    {
        $this->assign('cat', $this->cache->get('category'));
        $this->assign('menu', $this->optionMenu());

        return $this->display('admin/index');
    }

    public function mainAction()
    {
        $this->assign(array(
            'model' => $this->get_model(),
        ));
        return $this->display('admin/main');
    }

    public function cacheAction(Request $request)
    {
        $caches = array(
            array('21', 'auth', 'cache'),
            array('103', 'ip', 'cache'),
            array('30', 'tag', 'cache'),
            array('29', 'member', 'cache'),
            array('25', 'relatedlink', 'cache'),
            array('22', 'model', 'cache'),
            array('23', 'category', 'cache'),
            array('24', 'position', 'cache')
        );

        if ($request->get('show')) {
            delete_files(APP_ROOT . 'cache/models/');
            delete_files(APP_ROOT . 'cache/views/');
        } else {
            $this->assign('caches', $caches);
            return $this->display('admin/cache');
        }
    }

    public function ajaxcountAction()
    {
        if ($this->get('type') == 'member') {
            $c1 = $this->content->count('member', 'id', null);
            $c2 = $this->content->count('member', 'id', 'status=0');
            echo '$("#member_1").html("' . $c1 . '");$("#member_2").html("' . $c2 . '");';

        } elseif ($this->get('type') == 'install') {
            $ck = $this->cache->get('install');
            echo empty($ck) ? '' : "window.top.art.dialog({title:'" . lang('a-ind-41') . "',fixed:true, content: '<a href=" . url('admin/index/cache') . " target=_blank>" . lang('a-ind-42') . "</a>'});";

        } else {
            $id = (int)$this->get('modelid');
            $c1 = $this->content->count(null, 'modelid=' . $id, null, 36000);
            if ($catids = $this->getVerifyCatid()) {    //角色审核权限
                $where = 'catid not in (' . implode(',', $catids) . ') and modelid=' . $id;
            } else {
                $where = 'modelid=' . $id;
            }
            $c2 = $this->content->count('content_' . $this->siteid . '_verify', null, $where, null, 36000);
            echo '$("#m_' . $id . '_1").html("' . $c1 . '");$("#m_' . $id . '_2").html("' . $c2 . '");';
        }

        exit;
    }

    public function configAction(Request $request)
    {
        $string = array(
            'ADMIN_NAMESPACE' => lang('a-cfg-8'),
            'SYS_DOMAIN' => lang('a-cfg-11'),
            'SYS_DEBUG' => lang('a-cfg-9'),
            'SYS_LOG' => lang('a-cfg-10'),
            'SYS_VAR_PREX' => lang('a-cfg-13'),
            'SYS_GZIP' => lang('a-cfg-14'),
            'SITE_MEMBER_COOKIE' => lang('a-cfg-0'),
            'SESSION_COOKIE_DOMAIN' => lang('a-cfg-71'),
            'SYS_EDITOR' => lang('a-cfg-68'),
            'SYS_CAPTCHA_MODE' => lang('a-mod-161'),

            'SYS_ILLEGAL_CHAR' => lang('a-cfg-7'),
            'SYS_ATTACK_LOG' => lang('a-cfg-1'),
            'SYS_ATTACK_MAIL' => lang('a-cfg-2'),
            'SITE_SYSMAIL' => lang('a-cfg-4'),
            'SITE_ADMINLOG' => lang('a-cfg-24'),
            'SITE_MAIL_TYPE' => lang('a-cfg-25'),
            'SITE_MAIL_SERVER' => lang('a-cfg-26'),
            'SITE_MAIL_PORT' => lang('a-cfg-27'),
            'SITE_MAIL_FROM' => lang('a-cfg-28'),
            'SITE_MAIL_AUTH' => lang('a-cfg-29'),
            'SITE_MAIL_USER' => lang('a-cfg-30'),
            'SITE_MAIL_PASSWORD' => lang('a-cfg-31'),
            'SITE_MAP_TIME' => lang('a-cfg-32'),
            'SITE_MAP_NUM' => lang('a-cfg-33'),
            'SITE_MAP_UPDATE' => lang('a-cfg-34'),
            'SITE_MAP_AUTO' => lang('a-cfg-35'),
            'SITE_SEARCH_PAGE' => lang('a-cfg-36'),
            'SITE_SEARCH_TYPE' => lang('a-cfg-37'),
            'SITE_SEARCH_INDEX_CACHE' => lang('a-cfg-38'),
            'SITE_SEARCH_DATA_CACHE' => lang('a-cfg-39'),
            'SITE_SEARCH_SPHINX_HOST' => lang('a-cfg-40'),
            'SITE_SEARCH_SPHINX_PORT' => lang('a-cfg-41'),
            'SITE_SEARCH_SPHINX_NAME' => lang('a-cfg-42'),
            'SITE_ADMIN_CODE' => lang('a-cfg-43'),
            'SITE_ADMIN_PAGESIZE' => lang('a-cfg-46'),
            'SITE_SEARCH_KW_FIELDS' => lang('a-cfg-47'),
            'SITE_SEARCH_KW_OR' => lang('a-cfg-48'),
            'SITE_SEARCH_URLRULE' => lang('a-cfg-49'),
            'SITE_TAG_PAGE' => lang('a-cfg-50'),
            'SITE_TAG_CACHE' => lang('a-cfg-51'),
            'SITE_TAG_URLRULE' => lang('a-cfg-52'),
            'SITE_TAG_LINK' => lang('a-cfg-53'),
            'SITE_KEYWORD_NUMS' => lang('a-cfg-54'),
            'SITE_KEYWORD_CACHE' => lang('a-cfg-55'),
            'SITE_TAG_URL' => lang('a-cfg-56'),
            'SITE_COMMENT_SWITCH' => lang('a-cfg-75'),
            'SYS_MEMBER' => lang('t-002'),
            'SYS_MODE' => lang('t-003'),

            'SYS_GEE_CAPTCHA_ID' => '极验验证ID',
            'SYS_GEE_PRIVATE_KEY' => '极验验证KEY',
            'SITE_BDPING' => '百度Ping推送',

        );
        $config = $this->config;

        $theme = '';
        $file_list = file_list::get_file_list(VIEW_DIR);
        foreach ($file_list as $t) {
            if (is_dir(VIEW_DIR . $t) && strpos($t, 'mobile_') === false && !in_array($t, array('error', 'admin', 'index.html', 'install', 'mobile', 'weixin'))) {
                $theme .= '<option value="' . $t . '" ' . ($config['SITE_THEME'] == $t ? 'selected' : '') . '>' . $t . '</option>';
            }
        }
        if ($config['SITE_JS']) {
            $tmp = string2array($config['SITE_JS']);
            $config['SITE_JS'] = str_replace('{|}', "'", $tmp['value']);
        }

        if ($request->method() === 'POST' && $request->get('submit')) {
            $content = "<?php"
                . PHP_EOL . PHP_EOL
                . "/**" . PHP_EOL . " * 应用程序配置信息" . PHP_EOL . " */" . PHP_EOL
                . "return [" . PHP_EOL . PHP_EOL;

            $configdata = $request->get('data');
            foreach ($configdata as $var => $val) {
                $value = $val == 'false' || $val == 'true' ? $val : "'" . $val . "'";
                $content .= "	'" . strtoupper($var) . "'" . $this->setspace($var) . " => " . $value . ",  //" . $string[$var] . PHP_EOL;
            }

            $content .= PHP_EOL . "];";
            file_put_contents(APP_ROOT . 'Config/config.ini.php', $content);

            return $this->adminMsg(lang('success'), url('admin/index/config', array('type' => $this->get('type'))), 3, 1, 1);
        }

        $this->assign(array(
            'type' => $request->get('type') ? $request->get('type') : 1,
            'string' => $string,
            'data' => $config,
            'theme' => $theme,
            'langs' => file_list::get_file_list(APP_ROOT . 'Language' . DIRECTORY_SEPARATOR),
        ));
        return $this->display('admin/config');
    }

    public function logAction(Request $request)
    {
        $page = (int)$request->get('page') ? (int)$request->get('page') : 1;
        $pagelist = new pagelist();
        $pagelist->loadconfig();

        $data = array();
        $username = $request->get('submit') ? $request->get('kw') : $request->get('username');
        $logsdir = APP_ROOT . 'cache' . DIRECTORY_SEPARATOR . 'logs' . DIRECTORY_SEPARATOR;
        $filedata = file_list::get_file_list($logsdir);
        if ($filedata) {
            $filedata = array_reverse($filedata);

            foreach ($filedata as $file) {
                if (substr($file, -4) == '.log') {
                    $fdata = file_get_contents($logsdir . $file);
                    $fdata = explode(PHP_EOL, $fdata);

                    foreach ($fdata as $v) {
                        $t = unserialize($v);
                        if (is_array($t) && $t) {
                            if ($username) {
                                if ($t['username'] == $username) $data[] = $t;
                            } else {
                                $data[] = $t;
                            }
                        }
                    }
                }
            }
        }

        $total = count($data);
        $pagesize = isset($this->site['SITE_ADMIN_PAGESIZE']) && $this->site['SITE_ADMIN_PAGESIZE'] ? $this->site['SITE_ADMIN_PAGESIZE'] : 8;
        $list = array();
        $offset = ($page - 1) * $pagesize;
        foreach ($data as $i => $t) {
            if ($i >= $offset && $i < $offset + $pagesize) $list[] = $t;
        }
        $pagelist = $pagelist->total($total)->url(url('admin/index/log') . '?page={page}&username=' . $username)->num($pagesize)->page($page)->output();

        $this->assign(array(
            'list' => $list,
            'pagelist' => $pagelist
        ));
        return $this->display('admin/log');
    }

    public function clearlogAction()
    {
        $time = strtotime('-30 day');
        $logsdir = APP_ROOT . 'cache' . DIRECTORY_SEPARATOR . 'logs' . DIRECTORY_SEPARATOR;
        $filedata = file_list::get_file_list($logsdir);
        $count = 0;
        if ($filedata) {
            foreach ($filedata as $file) {
                if (substr($file, -4) == '.log') {
                    $name = substr($file, 0, 4) . '-' . substr($file, 4, 2) . '-' . substr($file, 6, 2);
                    if ($time > strtotime($name)) {
                        @unlink($logsdir . $file);
                        $count++;
                    }
                }
            }
        }

        return $this->adminMsg(lang('a-ind-32') . '(#' . $count . ')', url('admin/index/log'), 3, 1, 1);
    }

    public function attackAction(Request $request)
    {
        $page = (int)$request->get('page') ? (int)$request->get('page') : 1;
        $pagelist = new pagelist();
        $pagelist->loadconfig();
        $logsdir = APP_ROOT . 'cache' . DIRECTORY_SEPARATOR . 'attack' . DIRECTORY_SEPARATOR;
        $filedata = file_list::get_file_list($logsdir);
        $data = array();
        $ip = $request->get('submit') ? $request->get('kw') : $request->get('ip');
        if ($filedata) {
            $filedata = array_reverse($filedata);
            foreach ($filedata as $file) {
                if (substr($file, -4) == '.log') {
                    $fdata = file_get_contents($logsdir . $file);
                    $fdata = explode(PHP_EOL, $fdata);
                    foreach ($fdata as $v) {
                        $t = unserialize($v);
                        if ($t && is_array($t)) {
                            if ($ip) {
                                if ($t['ip'] == $ip) $data[] = $t;
                            } else {
                                $data[] = $t;
                            }
                        }
                    }
                }
            }
        }
        $total = count($data);
        $pagesize = isset($this->site['SITE_ADMIN_PAGESIZE']) && $this->site['SITE_ADMIN_PAGESIZE'] ? $this->site['SITE_ADMIN_PAGESIZE'] : 8;
        $list = array();
        $count_pg = ceil($total / $pagesize);
        $offset = ($page - 1) * $pagesize;
        foreach ($data as $i => $t) {
            if ($i >= $offset && $i < $offset + $pagesize) $list[] = $t;
        }
        $pagelist = $pagelist->total($total)->url(url('index/attack', array('page' => '{page}', 'ip' => $ip)))->num($pagesize)->page($page)->output();
        $this->assign(array(
            'ip' => $this->cache->get('ip'),
            'list' => $list,
            'pagelist' => $pagelist
        ));
        return $this->display('admin/attacklog');
    }

    public function clearattackAction()
    {
        $time = strtotime('-30 day');
        $logsdir = APP_ROOT . 'cache' . DIRECTORY_SEPARATOR . 'attack' . DIRECTORY_SEPARATOR;
        $filedata = file_list::get_file_list($logsdir);
        $count = 0;
        if ($filedata) {
            foreach ($filedata as $file) {
                if (substr($file, -4) == '.log') {
                    $name = substr($file, 0, 4) . '-' . substr($file, 4, 2) . '-' . substr($file, 6, 2);
                    if ($time > strtotime($name)) {
                        @unlink($logsdir . $file);
                        $count++;
                    }
                }
            }
        }
        return $this->adminMsg(lang('a-ind-32') . '(#' . $count . ')', url('admin/index/attack'), 3, 1, 1);
    }

    // todo 更新网站地图
    public function updatemapAction()
    {
        $fp = @fopen(APP_ROOT . 'finecms_test.txt', 'wb');
        if (!file_exists(APP_ROOT . 'finecms_test.txt') || $fp === false) return $this->adminMsg(lang('app-9', array('1' => APP_ROOT)));
        @fclose($fp);
        if (file_exists(APP_ROOT . 'finecms_test.txt')) unlink(APP_ROOT . 'finecms_test.txt');
        $count = sitemap_xml();
        return $this->adminMsg(lang('a-ind-39') . '(#' . $count . ')', '', 3, 1, 1);
    }

    private function setspace($var)
    {
        $len = strlen($var) + 2;
        $cha = 25 - $len;
        $str = '';
        for ($i = 0; $i < $cha; $i++) $str .= ' ';
        return $str;
    }
}