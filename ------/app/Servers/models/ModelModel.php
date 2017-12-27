<?php namespace App\Servers\models;

use App\Servers\drivers\App;

class ModelModel extends Model
{

    public function get_primary_key()
    {
        return $this->primary_key = 'modelid';
    }

    //获取网站id
    public function get_site_id($site = 0)
    {
        $site = $site ? $site : App::get_site_id();
        $sites = App::get_site();
        return $sites[$site]['SITE_EXTEND_ID'] ? $sites[$site]['SITE_EXTEND_ID'] : $site;
    }

    //获取模型数据
    public function get_data()
    {
        return $this->select();
    }

    //添加和修改模型
    public function set($modelid = 0, $data)
    {
        //修改模型
        if ($modelid) {
            $this->update($data, 'modelid=' . $modelid);
            return $modelid;
        }

        // 添加模型
        $this->insert($data);
        $modelid = $this->get_insert_id();
        if (empty($modelid)) return false;
        return $modelid;
    }

    //删除模型
    public function del($data)
    {
        $table = $this->prefix . $data['tablename'];
        $this->query('DROP TABLE IF EXISTS `' . $table . '`');
        $this->delete('modelid=' . $data['modelid']);
        $this->del_model($data['tablename']);
        $this->query('DELETE FROM `' . $this->prefix . 'model_field` where modelid=' . $data['modelid']);
        //删除多站点
        $sites = App::get_site();
        $config = App::get_config();
        foreach ($sites as $sid => $t) {
            if ($t['SITE_EXTEND_ID'] == $data['site'] || $data['site'] == $sid) {
                //继承网站则同步删除模型
                $table = preg_replace('/\_([0-9]+)\_/', '_' . $sid . '_', $data['tablename']);
                $this->query('DROP TABLE IF EXISTS `' . $this->prefix . $table . '`');
                $this->del_model($table);
            }
        }
        //删除栏目
        $this->query('DELETE FROM `' . $this->prefix . 'category` where modelid=' . $data['modelid']);
    }

    //创建模型
    public function create_model($table, $typeid)
    {
        if (strpos($table, 'member') !== false) return;
        $file = MODEL_DIR . 'callback/' . $table . '.php';
        if (is_file($file)) return;

        $c = "<?php namespace App\Servers\models;" . PHP_EOL . PHP_EOL .
            "function callback_{$table}(\$data) {" . PHP_EOL . PHP_EOL .
            " " . PHP_EOL . PHP_EOL .
            "}";
        file_put_contents($file, $c);
        return;
        $table = ucfirst($table);
        $e = $typeid == 3 ? "FormModel" : "Model";
        $c = "<?php namespace App\Servers\models;" . PHP_EOL . PHP_EOL .
            "class " . $table . "Model extends " . $e . " {" . PHP_EOL . PHP_EOL .
            "    public function get_primary_key() {" . PHP_EOL .
            "        return \$this->primary_key = 'id';" . PHP_EOL .
            "    }" . PHP_EOL . PHP_EOL .
            "    public function get_fields() {" . PHP_EOL .
            "        return \$this->get_table_fields();" . PHP_EOL .
            "    }" . PHP_EOL . PHP_EOL .
            "}";
        file_put_contents(MODEL_DIR . $table . 'Model.php', $c);
    }

    //删除模型文件
    protected function del_model($table)
    {
        $file = MODEL_DIR . ucfirst($table) . 'Model.php';
        if (file_exists($file)) @unlink($file);
    }
}