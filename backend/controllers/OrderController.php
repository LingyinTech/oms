<?php


namespace app\controllers;


use backend\base\Controller;
use backend\models\InvoiceType;
use backend\models\OrderInfo;
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

        $id = app()->request->get('id');
        if (!empty($id)) {
            $model = OrderInfo::findOne($id);
        }
        empty($model) && $model = new OrderInfo();

        if (app()->request->isPost) {
            if (($result = $model->saveOrder()) !== true) {
                if (is_string($result)) {
                    return $this->fail('保存失败' . $result);
                }
                return $this->format(['status' => 1, 'msg' => '保存失败', 'data' => $result]);
            }
            return $this->success('保存成功');
        }

        $modelForm = new OrderForm();

        if (!empty($model)) {
            //$modelForm->loadData($model);
        }

        return $this->render('add', [
            'model' => $model,
            'modelForm' => $modelForm,
            'orderTypeList' => array_merge(['' => '请选择'],(new OrderType())->getCache()),
            'payMethodList' => array_merge(['' => '请选择'],(new PayMethod())->getCache()),
            'invoiceTypeList' => array_merge(['' => '请选择'],(new InvoiceType())->getCache()),
        ]);
    }
}