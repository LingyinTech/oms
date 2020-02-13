<?php


namespace app\controllers;


use backend\base\Controller;
use backend\models\vo\OrderForm;

class OrderController extends Controller
{

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionAdd()
    {

        $model = new OrderForm();

        return $this->render('add',[
            'model' => $model,
        ]);
    }
}