<?php

namespace App\Services\Models;

use Illuminate\Database\Eloquent\Model;

class PositionDataModel extends Model
{
    use ModelTrait;

    public $timestamps = false;
    protected $table;
    protected $primaryKey;
    protected $guarded = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->table = $this->prefix . 'position_data';
        $this->primaryKey = 'id';
    }

    public function set($id, $data)
    {
        $data['catid'] = (int)$data['catid'];

        if ($id) {
            $check = $this->where('id', '<>', $id)
                ->where('catid', (int)$data['catid'])
                ->where('posid', $data['posid'])
                ->where('contentid', (int)$data['contentid'])
                ->get()->toArray();
            if ($data['contentid'] && $check) return false;
            $data['contentid'] = intval($data['contentid']);

            $this->where('id', $id)
                ->update($data);
            $this->updateContentAndUrl($data);

            return true;
        }

        if ($data['contentid'] && $data['catid']) {
            $check = $this->where('catid=' . (int)$data['catid'])->where('posid=' . $data['posid'])->where('contentid=' . (int)$data['contentid'])->select(false);
            if ($check) return false;
        }

        $data['contentid'] = intval($data['contentid']);
        $this->insert($data);
        if (!$this->get_insert_id()) return false;

        $this->updateContentAndUrl($data);

        return true;
    }

    private function updateContentAndUrl($data)
    {
        if (empty($data['contentid'])) return false;

        $content = \DB::select('select * from ' . $this->prefix . 'content where contid=?', [$data['contentid']]);
        if (empty($content)) return false;

        $position = @explode(',', $content['position']);
        $update = array();
        if (empty($position)) {
            $update = array($data['posid']);
        } else {
            foreach ($position as $p) {
                if ($p) $update[] = $p;
            }
            $update[] = $data['posid'];
            $update = array_unique($update);
        }
        $update = @implode(',', $update);

        \DB::updata('update ' . $this->prefix . 'content set position=? where contid=?', [$update, $data['contentid']]);
        \DB::update('update ' . $this->prefix . 'position_data set url=? where contentid=?', [$content['url'], $data['contentid']]);
    }

    public function del($posid)
    {
        $this->where('posid', $posid)
            ->delete();

        $table = $this->prefix . 'position_data';
        \DB::DELETE('delete from ' . $table . ' where posid=?', [$posid]);
    }
}