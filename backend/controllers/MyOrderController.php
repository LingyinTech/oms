<?php


namespace app\controllers;


use backend\base\Controller;

class MyOrderController extends Controller
{

    public function actionIndex()
    {
        return $this->render('index');
    }
}