<?php


namespace app\controllers;


use backend\base\Controller;
use backend\models\vo\WorkitemTypeForm;
use backend\models\WorkitemType;

class WorkitemTypeController extends Controller
{

    public function actionIndex()
    {
        return $this->render('index', []);
    }

    public function actionAdd()
    {
        $model = new WorkitemTypeForm();
        if ($id = app()->getRequest()->get('id')) {
            $model->initData($id);
        }
        return $this->render('add', [
            'model' => $model,
            'action' => '添加类别',
        ]);
    }
}