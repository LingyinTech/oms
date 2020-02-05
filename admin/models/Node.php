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
    const STATUS_MENU = 10;


    public function getCache()
    {
        $data = app()->cache->get('admin:node');
        if (empty($data)) {
            $list = $this->setWhere(['status' => 10])->asArray()->all();
            $data = [];
            foreach ($list as $item) {
                $data[$item['code']] = $item['label'];
            }
        }
        return $data;
    }

    public function getList($params)
    {
        $data = $this->setWhere($params);

        $page = app()->getRequest()->get('page', 1);
        $pageSize = app()->getRequest()->get('page_size', 20);
        $pages = new Pagination([
            'totalCount' => $data->count(),
            'pageSizeParam' => 'page_size',
            'pageSize' => $pageSize,
        ]);

        $data->limit($pageSize);
        $data->offset(($page - 1) * $pageSize);
        isset($params['select']) && $data->select($params['select']);
        isset($params['orderBy']) && $data->orderBy($params['orderBy']);

        return [
            'list' => $data->asArray()->all(),
            'pages' => $pages,
        ];
    }

    public function deleteCache()
    {
        return app()->cache->delete('admin:node');
    }

}