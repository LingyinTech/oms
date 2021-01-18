<?php


namespace lingyin\admin\controllers;


use lingyin\admin\base\Controller;
use lingyin\admin\models\Partner;
use lingyin\common\models\DbConfig;

class SystemController extends Controller
{

    public function actionDbConfig()
    {
        $model = new DbConfig();

        $list = $model->getList();

        $partnerIdArr = array_values(array_unique(array_column($list['list'], 'partner_id')));

        $partnerList = (new Partner())->getList(['in' => ['id' => $partnerIdArr],'select' => ['id', 'name']]);

        return $this->render(
            'index',
            [
                'model' => $model,
                'list' => $list['list'],
                'pages' => $list['pages'],
                'partnerList' => array_column($partnerList, 'name', 'id'),
                'statusList' => [
                    DbConfig::STATUS_INACTIVE => '未激活',
                    DbConfig::STATUS_ACTIVE => '活跃',
                    DbConfig::STATUS_DELETE => '已删除',
                ]
            ]
        );
    }

}