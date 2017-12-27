<?php

//function url($route, $params = null)
//{
//
//    if (file_exists(APP_ROOT . 'cache\member.lock')) {
//        $domain = explode(';', file_get_contents(APP_ROOT . 'cache\member.lock'));
//        if ($domain[1] && $route == 'api/user') {
//            $domain = 'http://' . str_replace('http://', '', $domain[1]) . '/member/index.php?c=api&m=userinfo';
//            return $domain;
//        }
//    }
//
//    if (!isset($params['siteid']) && isset($_GET['siteid']) && substr_count($route, '/') >= 2) {
//        //站点判断(前端控制器不带该参数)
//        $params['siteid'] = (int)$_GET['siteid'];
//        $params = array_reverse($params);
//    }
//    return ControllerTool::create_url($route, $params);
//}
//
//function dr_url($route, $params)
//{
//    return url($route, $params);
//}
//
///**
// * 插件中的URL函数
// */
//function purl($route, $params = '')
//{
//    return url(App::get_namespace_id() . '/' . $route, $params);
//}

/**
 * 语言调用函数
 */
function lang($name, $data = '')
{
    $language = \App\Servers\drivers\App::get_language();
    $string = isset($language[$name]) ? $language[$name] : $name;
    if ($data) {
        foreach ($data as $r => $t) {
            $string = str_replace('{' . $r . '}', $t, $string);
        }
    }
    return $string;
}

function dr_lang($name, $data = '')
{
    return lang($name, $data);
}

/**
 * 程序执行时间
 */
function runtime()
{
    $temptime = explode(' ', SYS_START_TIME);
    $time = $temptime[1] + $temptime[0];
    $temptime = explode(' ', microtime());
    $now = $temptime[1] + $temptime[0];
    return number_format($now - $time, 6);
}