<?php


namespace lingyin\admin\controllers;


use lingyin\admin\base\Controller;

class UserController extends Controller
{

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionPassword()
    {

    }
}