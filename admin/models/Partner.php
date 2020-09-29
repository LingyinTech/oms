<?php


namespace lingyin\admin\models;

use lingyin\admin\base\ActiveRecord;
use yii\data\Pagination;

class Partner extends ActiveRecord
{
    //状态:0未启用，1删除，2临时有效，10长期有效
    const STATUS_INACTIVE = 0;
    const STATUS_DELETE = 1;
    const STATUS_LIMITED = 2;
    const STATUS_ACTIVE = 10;


    public function getCache()
    {
        $data = app()->cache->get('admin:partner');
        if (empty($data)) {
            $list = $this->setWhere([])->asArray()->all();
            $data = [];
            foreach ($list as $item) {
                $data[$item['id']] = $item;
            }
            app()->cache->set('admin:partner', $data, 86400);
        }
        return $data;
    }

    public function deleteCache()
    {
        return app()->cache->delete('admin:partner');
    }

}