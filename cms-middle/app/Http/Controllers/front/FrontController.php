<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Common;
use App\Services\Models\SearchModel;
use Illuminate\Http\Request;

class FrontController extends Common
{
    //搜索关键字
    public function getKeywords(Request $request)
    {
        $search = new SearchModel();
        $search = $search->select('keywords as title')->distinct();
        $num = $request->get('num') || 5;

        if ($request->get('order')) {
            $order = null;
            $orders = explode(',', $request->get('order'));
            foreach ($orders as $t) {
                list($_field, $_order) = explode('_', $t);
                if (in_array($_field, array('id', 'keywords', 'addtime', 'total'))) {
                    $_orderby = isset($_order) && strtoupper($_order) == 'ASC' ? 'ASC' : 'DESC';

                    $search = $search->orderBy($_field, $_orderby);
                }
            }
        } else {
            $search = $search->orderBy('total', 'DESC');
        }

        $data = $search->take($num)->get()->toArray();

        return [
            'result' => $data,
            'total' => count($data)
        ];
    }

    //推荐位
    public function getPosition(Request $request)
    {
        $data = position($request->get('id'), $request->get('catid'), $request->get('num'));

        if ($data) {
            $db = ControllerTool::model('content');
            if (isset($system['more']) && $system['more']) {
                $cats = get_category_data($system['site']);
                $models = get_model_data('content', $system['site']);
            }
            foreach ($data as $i => $t) {
                if ($t['contentid']) {
                    $row = $db->db->where('id', $t['contentid'])->get('content_' . $system['site'])->row_array();
                    $cdata = $t + $row;
                    if (isset($system['more']) && $system['more']) {
                        $table = $models[$cats[$cdata['catid']]['modelid']]['tablename'];
                        if ($table) {
                            $row = $db->db->where('id', $t['contentid'])->get($table)->row_array();
                            if ($row) {
                                $cdata = $cdata + $row;
                            }
                        }
                    }
                    $data[$i] = $cdata;
                }
            }
        }
        if (isset($system['return']) && $system['return'] && $system['return'] != 't') {
            return array(
                'return_' . $system['return'] => $data,
                'total_' . $system['return'] => count($data)
            );
        }
        return array('result' => $data, 'total' => count($data));
    }

    public function getTag(Request $request)
    {
        // tag 标签aa
        $num = $system['num'] ? (int)$system['num'] : 999;
        $where = '';
        if (isset($fields['catid']) && $fields['catid']) { //栏目信息
            $where .= ' where catid=' . intval($fields['catid']);
        }
        $sql = 'select * from (select * from ' . $this->ci->db->dbprefix . 'tag ' . $where . ' order by listorder desc ) t group by letter order by listorder desc limit ' . $num;
        $tag = $this->ci->db->query($sql)->result_array();
        $data = array();
        if ($tag) {
            foreach ($tag as $t) {
                $t['url'] = SITE_URL . trim(tag_url($t['name']), '/');
                $data[] = $t;
            }
        }
        if (isset($system['return']) && $system['return'] && $system['return'] != 't') {
            return array(
                'return_' . $system['return'] => $data,
                'total_' . $system['return'] => count($data),
            );
        }
        return array('result' => $data, 'total' => count($data));
    }

    public function getRelation(Request $request)
    {
        if (isset($system['tag']) && $system['tag']) {
            //按关键字搜索
            if (isset($fields['id']) && $fields['id']) {
                $where .= '`id`<>' . (int)$fields['id'];
            }
            $tags = @explode(',', $system['tag']);
            $kwhere = $k = NULL;
            foreach ($tags as $tag) {
                if ($tag) {
                    if (empty($k)) {
                        $kwhere .= '`title` like "%' . $tag . '%"';
                    } else {
                        $kwhere .= ' OR `title` like "%' . $tag . '%"';
                    }
                    $k = 1;
                }
            }
            if ($kwhere) {
                $where .= ' AND (' . $kwhere . ')';
            }
            unset($k, $tags, $tag, $kwhere, $system['table'], $fields['id']);
        } else {
            //手动设置的相关文章
            $data = $this->relation($fields['id'], $system['num'], isset($system['more']) && $system['more']);
            if (isset($system['return']) && $system['return'] && $system['return'] != 't') {
                return array(
                    'return_' . $system['return'] => $data,
                    'total_' . $system['return'] => count($data),
                );
            }
            return array('return' => $data, 'total' => count($data));
        }
    }
}