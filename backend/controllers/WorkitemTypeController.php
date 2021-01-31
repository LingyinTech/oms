<?php


namespace app\controllers;


use backend\base\Controller;

class WorkitemTypeController extends Controller
{

    public function actionIndex()
    {
        return $this->render('index', []);
    }

}