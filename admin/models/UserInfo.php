<?php


namespace lingyin\admin\models;

use lingyin\admin\base\ActiveRecord;
use lingyin\admin\logic\PartnerLogic;
use yii\data\Pagination;

/**
 * Class UserInfo
 * @package backend\models
 * @property $user_id
 * @property $email
 */
class UserInfo extends ActiveRecord
{
    public function rules()
    {
        return [
            [['user_id', 'email'], 'required'],
            ['email', 'email', 'message' => '邮箱格式不合法'],
        ];
    }

    public function getList($params)
    {
        PartnerLogic::setPartnerId($params,'u.partner_id');

        $params['alias'] = 'ui';
        $params['join'] = ['user u' => 'u.id = ui.user_id'];

        $data = $this->setWhere($params);
        $page = app()->getRequest()->get('page', 1);
        $pageSize = app()->getRequest()->get('page_size', 20);
        $pages = new Pagination([
            'totalCount' => $data->count(),
            'pageSizeParam' => 'page_size',
            'pageSize' => $pageSize,
        ]);
        $data->select('ui.*,u.username,u.status,u.partner_id');
        $data->limit($pageSize);
        $data->offset(($page - 1) * $pageSize);
        isset($params['select']) && $data->select($params['select']);
        isset($params['orderBy']) && $data->orderBy($params['orderBy']);

        return [
            'list' => $data->asArray()->all(),
            'pages' => $pages,
        ];
    }
}