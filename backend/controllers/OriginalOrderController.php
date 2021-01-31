<?php


namespace app\controllers;


use backend\base\Controller;
use backend\models\InvoiceType;
use backend\models\OrderInfo;
use backend\models\OrderType;
use backend\models\PayMethod;
use backend\models\vo\OrderForm;

class OriginalOrderController extends Controller
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
}