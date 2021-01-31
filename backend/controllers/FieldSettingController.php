<?php


namespace app\controllers;


use backend\base\Controller;
use backend\models\FieldConfig;
use backend\models\vo\FieldConfigForm;

class FieldSettingController extends Controller
{

    public function actionIndex()
    {
        $model = new FieldConfigForm();
        $list = $model->getAll();

        return $this->render(
            'index',
            [
                'list' => $list,
                'statusList' => [
                    FieldConfig::STATUS_DELETE => '禁用',
                    FieldConfig::STATUS_ACTIVE => '启用',
                ],
            ]
        );
    }
}