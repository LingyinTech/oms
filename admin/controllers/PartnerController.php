<?php

namespace lingyin\admin\controllers;

use backend\base\Controller;
use lingyin\admin\models\Partner;
use lingyin\admin\models\vo\PartnerForm;

class PartnerController extends Controller
{

    public function actionIndex()
    {
        $model = new PartnerForm();

        $list = (new Partner())->getList([]);

        return $this->render('index', [
            'model' => $model,
            'list' => $list['list'],
            'pages' => $list['pages'],
            'statusList' => [
                Partner::STATUS_LIMITED => '限时有效',
                Partner::STATUS_ACTIVE => '长期有效',
                Partner::STATUS_DELETE => '禁用',
                Partner::STATUS_INACTIVE => '未启用',
            ],
        ]);
    }

    public function actionSave()
    {
        $model = new PartnerForm();
        if ($model->load(app()->request->post()) && $model->savePartner()) {
            return $this->success('保存成功');
        }
        return $this->format([
            'status' => 1,
            'msg' => '保存失败',
            'errors' => $model->getErrors(),
        ]);
    }

}