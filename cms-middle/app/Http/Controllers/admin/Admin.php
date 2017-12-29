<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Common;
use App\Services\models\userModel;
use Illuminate\Http\Request;

class Admin extends Common
{
    protected $user;
    protected $roleid;
    protected $userinfo;
    protected $site_url;

    public function __construct(Request $request)
    {
        parent::__construct($request);

        $this->user = new userModel();

        $userid = $this->session->get('user_id');
        $this->userinfo = $this->user->find($userid);
        if ($this->userinfo) {
            $this->roleid = $this->userinfo['roleid'];
        }

        $this->assign(array(
            'userinfo' => $this->userinfo,
            'site_url' => url()
        ));

        $this->adminLog($request);
    }

    /**
     * 系统默认菜单
     */
    protected function sysMenu()
    {
        $menu = require(APP_ROOT . 'Config/admin.menu.ini.php');

        // todo menu扩展
        $model = $this->get_model('form');
        if ($model) {
            $f = null;
            foreach ($model as $t) {
                if ($this->adminPost($t['setting']['auth'])) {
                    continue;
                }
                $id = $t['modelid'];
                $url = url('admin/form/list', array('modelid' => $id));
                $menu['site']['menu'][] = array(
                    'name' => $t['modelname'] . '管理',
                    'url' => $url
                );
            }
        }

        return $menu;
    }

    /**
     * 获取具有审核权限的栏目
     */
    protected function getVerifyCatid()
    {
        if ($this->userinfo['roleid'] == 1) {
            return false;
        }

        $catid = array();
        foreach ($this->cats as $t) {
            if ($t['child'] == 0 && $this->verifyPost($t['setting'])) {
                $catid[] = $t['catid'];
            }
        }

        return empty($catid) ? false : $catid;
    }

    /**
     * 投稿审核权限判断
     */
    protected function verifyPost($data)
    {
        if ($this->userinfo['roleid'] == 1) {
            return false;
        }

        if (isset($data['verifypost']) && $data['verifypost'] && $data['verifyrole'] && !in_array($this->userinfo['roleid'], $data['verifyrole'])) {
            return true;
        }

        return false;
    }

    /**
     * 后台投稿权限判断
     */
    protected function adminPost($data)
    {
        if (isset($data['adminpost'])
            && $data['adminpost']
            && $data['rolepost']
            && in_array($this->userinfo['roleid'], $data['rolepost'])
        ) {
            return true;
        } elseif (isset($data['siteuser'])
            && $data['siteuser']
            && $data['site']
            && in_array($this->siteid, $data['site'])
        ) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 指定用户组的操作菜单
     */
    protected function optionMenu($roleid = 0)
    {
        $menu = $this->sysMenu();

        $roleid = $roleid ? $roleid : $this->roleid;
        //加载用户自定义菜单
        $usermenu = string2array($this->userinfo['usermenu']);
        if ($roleid == 1) {
            if (!empty($usermenu)) {
                foreach ($usermenu as $k => $t) {
                    $menu['index']['menu'][] = array(
                        'name' => $t['name'],
                        'url' => str_replace('{site}', $this->siteid, $t['url'])
                    );
                }
            }
            return $menu;
        }

        if (!empty($usermenu)) {
            foreach ($usermenu as $k => $t) {
                $menu['index']['menu'][] = array(
                    'name' => $t['name'],
                    'url' => str_replace('{site}', $this->siteid, $t['url'])
                );
            }
        }
        // 判断权限
        foreach ($menu as $id => $t) {
            if (isset($t['menu'])) {
                foreach ($t['menu'] as $iid => $r) {
                    //内菜单控制
//                    if ($r['uri'] && !$this->checkUserAuth(array($r['uri']), $roleid)) {
//                        unset($menu[$id]['menu'][$iid]);
//                    } else {
//                        $menu[$id]['menu'][$iid]['url'] = $r['url'] ? $r['url'] : url($r['uri']);
//                    }

                }
                //如果子菜单全部被删除
                if (empty($menu[$id]['menu'])) {
                    unset($menu[$id]['menu']);
                }
            }
        }

        return $menu;
    }

    /**
     * 验证角色是否对指定菜单有操作权限
     */
    protected function checkUserAuth($option, $roleid = 0)
    {
        $data_role = require CONFIG_DIR . 'auth.role.ini.php';
        $roleid = $roleid ? $roleid : $this->roleid;
        $roleid = 1;
        $role = $data_role[$roleid];
        if (!$role) {
            return false;
        }
        if (!is_array($option)) {
            $option = array($option);
        }
        foreach ($role as $t) {
            if (in_array($t, $option)) {
                return true;
            }
        }
        return false;
    }

    protected function adminLog(Request $request)
    {
        $route_name = \Route::currentRouteName();
        if ($request->method() !== 'POST' || $this->config['SITE_ADMINLOG'] === false || $request->ajax() !== false) {
            return false;
        }

        //跳过不要记录的操作
        $skip = require APP_ROOT . 'Config/auth.skip.ini.php';
        $skip = $skip['admin'];
        $skip[] = 'index/log';
        if (in_array($route_name, $skip)) {
            return false;
        }

        //记录操作日志
        $options = require APP_ROOT . 'Config/auth.option.ini.php';
        $option = $options[explode('/', $route_name)[1]];
        if (empty($option)) {
            return false;
        }

        $ip = $request->ip();
        $pathurl = $request->getRequestUri();
        $options = lang($option['name']) . ' - ' . lang($option['option'][explode('/', $route_name)[2]]);
        if ($this->post('submit')) {
            $options .= ' - ' . lang('a-com-2');
        } elseif (($this->post('submit_order'))) {
            $options .= ' - ' . lang('a-com-3');
        } elseif (($this->post('submit_del'))) {
            $options .= ' - ' . lang('a-com-4');
        } elseif (($this->post('submit_status_1'))) {
            $options .= ' - ' . lang('a-com-5');
        } elseif (($this->post('submit_status_0'))) {
            $options .= ' - ' . lang('a-com-6');
        } elseif (($this->post('submit_status_2'))) {
            $options .= ' - ' . lang('a-com-7');
        } elseif (($this->post('submit_status_3'))) {
            $options .= ' - ' . lang('a-com-8');
        } elseif (($this->post('submit_move'))) {
            $options .= ' - ' . lang('a-com-9');
        } elseif (($this->post('delete'))) {
            $options .= ' - ' . lang('a-com-10');
        }
        $data = array(
            'ip' => $ip,
            'param' => $pathurl,
            'userid' => $this->userinfo['userid'],
            'action' => $this->action,
            'options' => $options,
            'username' => $this->userinfo['username'],
            'controller' => $this->controller,
            'optiontime' => time()
        );
        $dir = APP_ROOT . 'cache' . DIRECTORY_SEPARATOR . 'logs' . DIRECTORY_SEPARATOR;
        $file = $dir . date('Ymd') . '.log';
        if (!is_dir($dir)) {
            mkdir($dir, 0777);
        }
        $content = file_exists($file) ? file_get_contents($file) : '';
        $content = serialize($data) . PHP_EOL . $content;
        file_put_contents($file, $content, LOCK_EX);
    }

    /**
     * 删除目录及文件
     */
    protected function delDir($filename)
    {
        if (empty($filename)) {
            return false;
        }
        if (is_file($filename) && file_exists($filename)) {
            unlink($filename);
        } else if ($filename != '.' && $filename != '..' && is_dir($filename)) {
            $dirs = scandir($filename);
            foreach ($dirs as $file) {
                if ($file != '.' && $file != '..') {
                    $this->delDir($filename . '/' . $file);
                }
            }
            rmdir($filename);
        }
    }

    /**
     * 生成栏目html
     */
    protected function createCat($cat, $page = 1)
    {
        if ($cat['typeid'] == 3) {
            return false;
        }
        if ($cat['setting']['url']['use'] == 0
            || $cat['setting']['url']['tohtml'] == 0
            || $cat['setting']['url']['list'] == ''
        ) {
            return false;
        }

        $url = substr($this->getCaturl($cat, $page), strlen(self::get_base_url())); //去掉域名部分
        if (strpos($url, 'index.php') !== false || strpos($url, 'http://') != false) {
            return false;
        }
        if (substr($url, -5) != '.html') {
            $file = 'index.html'; //文件名
            $dir = $url; //目录
        } else {
            $file = basename($url);
            $dir = str_replace($file, '', $url);
        }
        $this->mkdirs($dir);
        $dir = substr($dir, -1) == '/' ? substr($dir, 0, -1) : $dir;
        $htmlfile = $dir ? $dir . '/' . $file : $file;

        ob_start();
        $catid = $cat['catid'];
        $cat = $this->cats[$catid];
        if (empty($cat)) {
            return;
        }

        if ($cat['typeid'] == 1) {
            //内部栏目
            $this->assign($cat);
            $this->assign(listSeo($cat, $page));
            $this->assign(array(
                'page' => $page,
                'catid' => $catid,
                'pageurl' => urlencode($this->getCaturl($cat, '{page}'))
            ));
            $this->display(substr(($cat['child'] == 1 ? $cat['categorytpl'] : $cat['listtpl']), 0, -5));
        } elseif ($cat['typeid'] == 2) {
            //单网页
            $cat = $this->get_content_page($cat, 0, $page);
            $cat['content'] = relatedlink($cat['content']);
            $this->assign($cat);
            $this->assign(listSeo($cat, $page));
            $this->display(substr($cat['showtpl'], 0, -5));
        }

        if (!file_put_contents($htmlfile, ob_get_clean(), LOCK_EX)) {
            return $this->adminMsg(lang('a-com-11', array('1' => $htmlfile)));
        }
        $htmlfiles = $this->cache->get('html_files');
        $htmlfiles[] = $htmlfile;
        if (empty($page) || $page == 1) {
            $onefile = str_replace('{page}', 1, substr($this->getCaturl($cat, '{page}'), strlen(self::get_base_url())));
            @copy($htmlfile, $onefile);
            $htmlfiles[] = $onefile;
        }
        $this->cache->set('html_files', $htmlfiles);
        if (strpos($cat['content'], '{-page-}') !== false) {
            $content = explode('{-page-}', $cat['content']);
            $pageid = count($content) >= $page ? ($page - 1) : (count($content) - 1);
            $page_id = 1;
            $pagelist = array();
            $cat['content'] = $content[$pageid];
            foreach ($content as $t) {
                $pagelist[$page_id] = getCaturl($cat, $page_id);
                $page_id++;
            }
            if (isset($pagelist[$page + 1])) {
                $this->createCat($cat, $page + 1);
            }
        }
        return true;
    }

    protected function getCacheCode($url)
    {
        return '<script type="text/javascript" src="' . url($url) . '"></script>';
    }

    /**
     * Check repeated category in given tag/tags.
     * @param $data
     * @param int $mode
     * @return bool
     */
    public function checkRepeat($data, $mode = 0, $id = 0)
    {
        if ($mode === 0) {
            foreach ($data as $id => $t) {
                $catid = $t['catid'];
                $name = $t['name'];
                unset($data[$id]);
                foreach ($data as $d) {
                    if (in_array($catid, $d) && in_array($name, $d))
                        return TRUE;
                }
            }

            return FALSE;

        } elseif ($mode === 1) {
            $count = \DB::select('select count(*) from ' . $this->db_prefix . '_tag where id<>' . $id . ' and catid=' . $data['catid'] . ' and name=' . $data['name']);

            return $count > 0 ? TRUE : FALSE;

        } else {
            $count = \DB::select('select count(*) from ' . $this->db_prefix . '_tag where id<>' . $id . ' and catid=' . $data['catid'] . ' and name=' . $data['name']);

            return $count > 1 ? TRUE : FALSE;
        }
    }

}