<?php


namespace app\controllers;


use backend\base\Controller;
use backend\models\Template;
use backend\models\vo\TemplateForm;

class TemplateController extends Controller
{

    public function actionIndex()
    {
        $model = new TemplateForm();
        $list = $model->getAll();

        return $this->render(
            'index',
            [
                'list' => $list,
                'statusList' => [
                    Template::STATUS_DELETE => '禁用',
                    Template::STATUS_ACTIVE => '启用',
                ],
            ]
        );
    }
}