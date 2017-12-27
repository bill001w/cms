<?php namespace App\Services\dayrui\libraries;

namespace App\Services\dayrui\libraries;

class cache_file
{

    /**
     * 缓存目录
     *
     * @var string
     */
    public $cache_dir;


    /**
     * 构造函数,初始化变量
     *
     * @access public
     * @return boolean
     */
    public function __construct()
    {
        $this->cache_dir = APP_ROOT . 'cache' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR;
        return true;
    }

    /**
     * 分析缓存文件名.
     *
     * @param string $file_name
     * @return string
     */
    protected function parse_cache_file($file_name)
    {
        return $this->cache_dir . $file_name . '.cache.php';
    }

    /**
     * 设置缓存
     *
     * @param string $key
     * @param string $value
     * @return boolean
     */
    public function set($key, $value)
    {
        if (!$key) {
            return false;
        }
        $value = (!is_array($value)) ? serialize(trim($value)) : serialize($value);

        $cache_file = $this->parse_cache_file($key);
        if (!is_dir($this->cache_dir)) {
            mkdir($this->cache_dir, 0777);
        } else {
            if (!is_writeable($this->cache_dir)) {
                @chmod($this->cache_dir, 0777);
            }
        }
        $r = @file_put_contents($cache_file, $value, LOCK_EX);
        if ($r === FALSE) {
            show_error('cache目录无写入权限，文件' . $cache_file . '写入失败');
        }
        return $r ? true : false;
    }

    /**
     * 获取一个已经缓存的变量
     *
     * @param string $key
     * @return string
     */
    public function get($key)
    {
        if (!$key) {
            return false;
        }

        $cache_file = $this->parse_cache_file($key);
        return is_file($cache_file) ? unserialize(file_get_contents($cache_file)) : false;
    }

    /**
     * 删除缓存
     *
     * @param string $key
     * @return void
     */
    public function delete($key)
    {
        if (!$key) {
            return true;
        }
        //分析缓存文件
        $cache_file = $this->parse_cache_file($key);
        return is_file($cache_file) ? unlink($cache_file) : true;
    }
}