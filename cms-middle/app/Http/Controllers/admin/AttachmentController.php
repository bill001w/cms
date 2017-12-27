<?php

namespace App\Http\Controllers\admin;

use App\Services\dayrui\libraries\file_list;
use Illuminate\Http\Request;

class AttachmentController extends Admin
{
    protected $dir = 'uploadfiles/';

    public function indexAction(Request $request)
    {
        $iframe = $request->get('iframe') ? 1 : 0;
        $dir = $request->get('dir') ? base64_decode($this->get('dir')) : '';
        $dir = substr($dir, 0, 1) == '/' ? substr($dir, 1) : $dir;
        $dir = str_replace('//', '/', $dir);
        if ($this->checkFileName($dir)) return $this->adminMsg(lang('m-con-20'));

        $list = array();
        if ($request->method() === 'POST' && $request->get('submit')) {
            $name = $request->get('kw');
            if (empty($name)) return $this->adminMsg(lang('a-att-31'));
            if ($this->checkFileName($name)) return $this->adminMsg(lang('m-con-20'));
            $dir = '';

            $data = $this->getfiles($this->dir, $name);
        } else {
            $data = file_list::get_file_list($this->dir . $dir);
        }

        if ($data) {
            foreach ($data as $t) {
                if ($t == 'index.html') continue;

                $path = $dir . $t . '/';
                $ext = is_dir($this->dir . $path) ? 'dir' : strtolower(trim(substr(strrchr($t, '.'), 1, 10)));
                $ico = file_exists(basename(VIEW_DIR) . '/admin/images/ext/' . $ext . '.gif') ? $ext . '.gif' : $ext . '.png';
                $fileinfo = array();
                if (is_file($this->dir . $dir . $t)) {
                    $file = $this->dir . $dir . $t;
                    $fileinfo = array(
                        'path' => $file,
                        'time' => date(TIME_FORMAT, filemtime($file)),
                        'size' => formatFileSize(filesize($file)),
                        'ext' => $ext,
                    );
                }

                $list[] = array(
                    'name' => $t,
                    'dir' => base64_encode($path),
                    'path' => $this->dir . $path,
                    'ico' => $ico,
                    'isimg' => in_array($ext, array('gif', 'jpg', 'png', 'jpeg', 'bmp')) ? 1 : 0,
                    'isdir' => is_dir($this->dir . $path) ? 1 : 0,
                    'fileinfo' => $fileinfo,
                    'url' => is_dir($this->dir . $path) ? url('admin/attachment/index') . '?dir=' . base64_encode($path) . '&iframe=' . $iframe : '',
                );
            }
        }

        $this->assign(array(
            'dir' => $this->dir . $dir,
            'istop' => $dir ? 1 : 0,
            'pdir' => url('admin/attachment/index') . '?dir=' . base64_encode(str_replace(basename($dir), '', $dir)) . '&iframe=' . $iframe,
            'list' => $list,
            'iframe' => $iframe,
        ));
        return $this->display('admin/attachment_list');
    }

    public function delAction($name)
    {
        $dir = base64_decode($name);
        $name = $this->dir . $dir;
        $name = substr($name, -1) == '/' ? substr($name, 0, -1) : $name;

        if ($this->checkFileName($name)) return $this->adminMsg(lang('m-con-20'));
        if ($this->dir == $name || $this->dir == $name . '/') return $this->adminMsg(lang('a-att-0'));
        if (!file_exists($name)) return $this->adminMsg(lang('a-att-1', array('1' => $name)));

        if (is_dir($name)) {
            $this->delDir($name);
            return $this->adminMsg(lang('a-att-2'), url('admin/attachment/index', array('dir' => base64_encode(str_replace(basename($dir), '', $dir)))), 3, 1, 1);
        }

        if (is_file($name)) {
            unlink($name);
            return $this->adminMsg(lang('a-att-3'), url('admin/attachment/index', array('dir' => base64_encode(str_replace(basename($dir), '', $dir)))), 3, 1, 1);
        }
    }

    private function getfiles($path, $name, &$files = array())
    {
        if (!is_dir($path)) return null;

        $handle = opendir($path);
        while (false !== ($file = readdir($handle))) {
            if ($file != '.' && $file != '..' && $file != 'index.html') {
                $path2 = $path . $file;
                if (is_dir($path2)) {
                    $this->getfiles($path2 . '/', $name, $files);
                } else {
                    if (strpos($path2, $name) !== false) $files[] = substr($path2, 0, 12) == $this->dir ? substr($path2, 12) : $path2;
                }
            }
        }

        return $files;
    }
}