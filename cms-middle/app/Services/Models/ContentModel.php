<?php

namespace App\Services\Models;

use App\Services\Core\Basic;
use App\Services\dayrui\libraries\cache_file;
use App\Services\dayrui\libraries\image_lib;
use Illuminate\Database\Eloquent\Model;

class ContentModel extends Model
{
    use ModelTrait;

    public $timestamps = false;
    protected $table;
    protected $primaryKey;
    protected $guarded = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->table = $this->prefix . 'content';
        $this->primaryKey = 'contid';
    }

    public function get_data($id)
    {
        $data = $this->find($id);

        return $data;
    }

    public function set($id, $tablename, $data)
    {
        if (!$this->is_table_exists($tablename)) {
            return lang('m-con-37', array('1' => $tablename));
        }
        if (empty($data['catid'])) {
            return lang('m-con-8');
        }

        $modelName = 'App\\Servers\\models\\' . ucfirst($tablename) . 'Model';
        $table = new $modelName();

        $id = intval($id);
        $_data = $id ? $this->find($id) : null;
        //数组转化为字符
        foreach ($data as $i => $t) {
            if (is_array($t)) {
                $data[$i] = array2string($t);
            }
        }

        //描述截取
        if (empty($data['description']) && isset($data['content'])) {
            $len = isset($data['fn_add_introduce']) && $data['fn_add_introduce'] && $data['fn_introcude_length'] ? $data['fn_introcude_length'] : 200;
            $data['description'] = str_replace(PHP_EOL, '', strcut(clearhtml($data['content']), $len));
        }

        //下载远程图片
        if (isset($data['content']) && isset($data['fn_down_image']) && $data['fn_down_image']) {
            $content = str_replace(array('\\', '"'), array('', '\''), htmlspecialchars_decode($data['content']));

            if (preg_match_all("/(src)=([\"|']?)([^ \"'>]+\.(gif|jpg|jpeg|bmp|png))\\2/i", $content, $imgs)) {
                $userid = !$data['sysadd'] && $data['userid'] ? $data['userid'] : (!$_data['sysadd'] && $_data['userid'] ? $_data['userid'] : 0);
                $sysadd = $data['sysadd'] ? $data['sysadd'] : ($_data['sysadd'] ? $_data['sysadd'] : 0);
                //表示会员投稿
                if ($userid) {
                    $member = \DB::table($this->prefix . 'member')->select(['groupid'])->where('id', $id)->get()->toArray();
                    $group = \DB::table($this->prefix . 'member_group')->where('id', (int)$member['groupid'])->get()->toArray();
                    $result = $this->download_images($imgs[3], $userid, (int)$group['filesize']);
                    //表示管理员投稿
                } elseif ($sysadd) {
                    $result = $this->download_images($imgs[3]);
                }

                if (isset($result) && $result) {
                    $image = $result['replace'][0];
                    $data['content'] = str_replace($result['regex'], $result['replace'], $data['content']);
                }
            }
        }

        //提取缩略图
        if (empty($data['thumb']) && isset($data['content']) && isset($data['fn_auto_thumb']) && $data['fn_auto_thumb']) {
            if (isset($image)) {
                $data['thumb'] = $image;
            } else {
                $content = str_replace(array('\\', '"'), array('', '\''), htmlspecialchars_decode($data['content']));
                if (preg_match("/(src)=([\"|']?)([^ \"'>]+\.(gif|jpg|jpeg|bmp|png))\\2/i", $content, $img)) {
                    $data['thumb'] = $img[3];
                }
            }
        }

        //关键字处理
        if ($data['keywords']) {
            $data['keywords'] = str_replace('，', ',', $data['keywords']);
            $tags = @explode(',', $data['keywords']);
            $tags = array_unique($tags);

            if ($tags) {
                foreach ($tags as $t) {
                    $name = trim($t);
                    if ($name) {
                        $d = \DB::select('select tag,id from ' . $this->prefix . 'tag where name=? and catid=?', [$name, $data['catid']]);
                        if (empty($d)) {
                            $d = \DB::insert('insert into ' . $this->prefix . 'tag (`name`,`letter`,`catid`, `listorder`) VALUES (?, ?, ?, ?)', [$name, word2pinyin($name), $data['catid'], 0]);
                        }
                    }
                }
            }
        }

        $status = 1; //用于判断积分增加
        $is_add = 0;
        if ($id) { //修改
            if (empty($_data)) {
                $data['id'] = $id;
                $data['url'] = getUrl($data); //更新URL
                $data['hits'] = 0;
                $data['status'] = 1; //插入时状态设置为1
                $data['listorder'] = 0;
                $this->create($data);
                $table->create($data);
                $is_add = 1;
            } else {
                $data['id'] = $data['id'] ? $data['id'] : $id;
                $data['url'] = getUrl($data); //更新URL
                unset($data['id']);
                $data['status'] = $data['status'] > 0 ? 1 : 0; //修改时，非0状态设置为1
                $this->where('id=', $id)->update($data);
                $table->where('id=', $id)->update($data);
                $status = 0; //修改时不作为积分处理
                $data['userid'] = $_data['userid'];
                $data['listorder'] = $_data['listorder'] ? $_data['listorder'] : 0;
            }
        } else { //添加
            $data['hits'] = 0;
            $data['status'] = 1; //插入时状态设置为1
            $data['listorder'] = 0;
            if ($id = $this->create($data)->{$this->primaryKey}) {
                $data['url'] = getUrl(array_merge($data, ['id' => $id])); //更新URL
                $this->where('id=', $id)->update($data);

                $data['id'] = $id;
                $table->create($data);
            }

            $is_add = 1;
        }

        //积分处理 非系统添加且（增加时，文档状态等于1）
        if (!$data['sysadd'] && $status == 1) {
            $this->credits($data['userid'], 1);
        }

        // 添加数据的处理
        if ($is_add) {
            // 推送微信
            //$this->post_weixin($id);
        }

        return $id;
    }

    public function del($id, $catid)
    {
        $data = $this->find($id);
        if (empty($data)) {
            return false;
        }

        $model = get_model_data('model');
        $table = $model[$data['modelid']]['tablename'];
        if (empty($table) || empty($id)) {
            return false;
        }

        $this->delete('id=' . $id);
        $this->query('delete from ' . $this->prefix . $table . ' where id=' . $id);

        if (empty($data['sysadd']) && $data['username'] && is_numeric($data['userid'])) {
            $this->credits($data['userid'], 0);
        }

        // 删除静态页
        $file = substr($data['url'], strlen(ControllerTool::get_base_url())); //去掉主域名
        $file = substr($file, 0, 9) == 'index.php' ? null : $file; //是否为动态链接
        if ($file && file_exists($file)) {
            @unlink($file);
        }

        //删除推荐位信息
        $this->query('delete from ' . $this->prefix . 'position_data where contentid=' . $id);
    }

    public function credits($userid, $action)
    {
        if (empty($userid)) {
            return false;
        }

        $member = \DB::table($this->prefix . 'member')->where('id', $userid)->get()->toArray();
        if (empty($member)) {
            return false;
        }

        $cache = new cache_file();
        $config = $cache->get('member');
        if (isset($config['postcredits']) && $config['postcredits'] && $action == 1) {
            //增加积分
            $credit = $member['credits'] + (int)$config['postcredits'];
        } elseif (isset($config['delcredits']) && $config['delcredits'] && $action == 0) {
            //删除积分
            $credit = $member['credits'] - (int)$config['delcredits'];
        }
        if (isset($credit) && $credit != '') \DB::table($this->prefix . 'member')->where('id', $userid)->update('credits', (int)$credit);
    }

    private function download_images($imgs, $uid = 0, $size = 0)
    {
        $imgs = array_unique($imgs);    //去除重复图片
        $regex = $replace = array();
        $path = $uid ? 'uploadfiles/member/' . $uid . '/image/' . date('Ym') . '/' : 'uploadfiles/image/' . date('Ym') . '/';
        $this->mkdirs($path);
        //水印
        $config = Basic::$config;
        if ($config['SITE_WATERMARK']) $image = new image_lib();
        foreach ($imgs as $img) {
            if ($uid && $size && count_member_size($uid) > $size * 1024 * 1024) continue;
            if (strpos($img, url()) !== false || substr($img, 0, 7) != 'http://') continue;
            //下载图片
            $fileext = strtolower(trim(substr(strrchr($img, '.'), 1, 10))); //扩展名
            $name = $path . md5($img . time()) . '.' . $fileext;
            $content = fn_geturl($img);
            if (empty($content)) continue;
            if (file_put_contents($name, $content)) {
                if ($config['SITE_WATERMARK']) {
                    if ($config['SITE_WATERMARK'] == 1) {
                        $image->set_watermark_alpha($config['SITE_WATERMARK_ALPHA']);
                        $image->make_image_watermark($name, $config['SITE_WATERMARK_POS'], $config['SITE_WATERMARK_IMAGE']);
                    } else {
                        $image->set_text_content($config['SITE_WATERMARK_TEXT']);
                        $image->make_text_watermark($name, $config['SITE_WATERMARK_POS'], $config['SITE_WATERMARK_SIZE']);
                    }
                }
                $regex[] = $img;
                $replace[] = $name;
            }
        }

        return count($regex) > 0 ? array('regex' => $regex, 'replace' => $replace) : null;
    }

    private function mkdirs($dir)
    {
        if (!is_dir($dir)) {
            $this->mkdirs(dirname($dir));
            mkdir($dir);
        }
    }
}