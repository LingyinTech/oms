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
                    FieldConfig::STATUS_INACTIVE => '未发布',
                    FieldConfig::STATUS_DELETE => '禁用',
                    FieldConfig::STATUS_ACTIVE => '启用',
                ],
            ]
        );
    }

    public function actionAdd()
    {
        $model = new FieldConfigForm();
        if ($id = app()->getRequest()->get('id')) {
            $model->initData($id);
        }

        return $this->render(
            'add',
            [
                'model' => $model,
                'action' => $model->id ? '编辑字段' : '添加字段',
                'fieldTypeList' => FieldConfig::FIELD_TYPE,
                'statusList' => [
                    FieldConfig::STATUS_INACTIVE => '未发布',
                    FieldConfig::STATUS_ACTIVE => '可使用',
                ]
            ]
        );
    }

    public function actionSave()
    {
        $model = new FieldConfigForm();
        if ($model->load(app()->request->post()) && $model->saveField()) {
            return $this->success('保存成功');
        }
        return $this->format(
            [
                'status' => 1,
                'msg' => '保存失败',
                'errors' => $model->getErrors(),
            ]
        );
    }
}