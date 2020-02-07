<?php


namespace lingyin\admin\controllers;


use lingyin\admin\base\Controller;

class ProfileController extends Controller
{
    public function actionIndex()
    {

        return $this->render('index');
    }

    public function actionPassword()
    {
        return $this->render('password');
    }
}