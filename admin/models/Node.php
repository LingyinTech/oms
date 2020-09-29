<?php


namespace lingyin\admin\models;

use lingyin\admin\base\ActiveRecord;
use yii\data\Pagination;

class Node extends ActiveRecord
{
    //状态，0未开放，1删除，2动作，10菜单
    const STATUS_INACTIVE = 0;
    const STATUS_DELETE = 1;
    const STATUS_ACTION = 2;
    const STATUS_ELEMENT = 3;
    const STATUS_MENU = 10;

    public function getCache()
    {
        $data = app()->cache->get('admin:node');
        if (empty($data)) {
            $list = $this->setWhere([])->asArray()->all();
            $data = [];
            foreach ($list as $item) {
                $data[$item['id']] = $item;
            }
            app()->cache->set('admin:node', $data);
        }
        return $data;
    }

    public function deleteCache()
    {
        return app()->cache->delete('admin:node');
    }

}