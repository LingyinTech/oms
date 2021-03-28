<?php


namespace app\controllers;


use backend\base\Controller;
use backend\models\ViewConfig;
use backend\models\vo\ViewConfigForm;

class ViewConfigController extends Controller
{

    public function actionIndex()
    {
        $list = (new ViewConfigForm())->getAll();

        return $this->render(
            'index',
            [
                'list' => $list,
                'statusList' => [
                    ViewConfig::STATUS_INACTIVE => '未完成配置',
                    ViewConfig::STATUS_DELETE => '已删除',
                    ViewConfig::STATUS_PRIVATE => '个人视图',
                    ViewConfig::STATUS_ACTIVE => '公共视图',
                ]
            ]
        );
    }
}