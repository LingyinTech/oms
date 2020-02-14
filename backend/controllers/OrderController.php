<?php


namespace app\controllers;


use backend\base\Controller;
use backend\models\OrderType;
use backend\models\PayMethod;
use backend\models\vo\OrderForm;

class OrderController extends Controller
{

    public function actionIndex()
    {
        $orderTypeList = (new OrderType())->getCache();
        $payMethodList = (new PayMethod())->getCache();

        return $this->render('index',[
            'orderTypeList' => $orderTypeList,
            'payMethodList' => $payMethodList,
        ]);
    }

    public function actionAdd()
    {

        $model = new OrderForm();

        $orderTypeList = (new OrderType())->getCache();
        $payMethodList = (new PayMethod())->getCache();

        return $this->render('add',[
            'model' => $model,
            'orderTypeList' => $orderTypeList,
            'payMethodList' => $payMethodList,
        ]);
    }
}