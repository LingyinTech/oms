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
                    Template::STATUS_INACTIVE => '待启用',
                    Template::STATUS_DELETE => '禁用',
                    Template::STATUS_ACTIVE => '启用',
                ],
            ]
        );
    }

    public function actionAdd()
    {
        $model = new TemplateForm();

        if (app()->request->isPost) {
            if ($model->load(app()->request->post())
                && $model->saveTemplate()) {
                return $this->success('保存成功');
            }

            $errors = $model->getErrors();

            return $this->format(
                [
                    'status' => 1,
                    'msg' => isset($errors['msg']) ? current($errors['msg'])
                        : '保存失败',
                    'errors' => $errors,
                ]
            );
        }


        if ($id = app()->getRequest()->get('id')) {
            $model->initData($id);
        }

        return $this->render(
            'add',
            [
                'action' => $model->id ? '编辑模板' : '添加模板',
                'model' => $model,
                'statusList' => [
                    Template::STATUS_INACTIVE => '未发布',
                    Template::STATUS_ACTIVE => '可使用',
                ]
            ]
        );
    }
}