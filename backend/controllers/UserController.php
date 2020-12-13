<?php


namespace app\controllers;


use backend\base\Controller;
use lingyin\admin\models\vo\LoginForm;
use lingyin\admin\models\vo\RegisterForm;
use yii\helpers\Url;

class UserController extends Controller
{

    public function actionLogin()
    {
        if (!app()->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(app()->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $this->layout = '//main-login';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionRegister()
    {
        if (!app()->user->isGuest) {
            return $this->goHome();
        }
        $model = new RegisterForm();
        if ($model->load(app()->request->post()) && $model->register()) {
            return $this->redirect(Url::toRoute(['user/login']));
        }

        $this->layout = '//main-login';
        return $this->render('register', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        app()->user->logout();

        return $this->goHome();
    }

}