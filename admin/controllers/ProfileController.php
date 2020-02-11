<?php


namespace lingyin\admin\controllers;


use lingyin\admin\base\Controller;
use lingyin\admin\models\vo\PasswordForm;

class ProfileController extends Controller
{
    public function actionIndex()
    {

        return $this->render('index');
    }

    public function actionPassword()
    {
        $model = new PasswordForm();

        if (app()->request->isPost) {
            if ($model->load(app()->request->post()) && $model->modifyPassword()) {
                return $this->success('修改成功');
            }
            return $this->fail('修改失败', $model->getErrors());
        }

        return $this->render('password', [
            'model' => $model,
        ]);
    }
}