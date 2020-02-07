<?php


namespace app\controllers;


use backend\base\Controller;

class OrderController extends Controller
{

    public function actionIndex()
    {
        return $this->render('index');
    }
}