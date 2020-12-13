<?php
/**
 * Created by PhpStorm.
 * User: huanjin
 * Date: 2018/5/30
 * Time: 22:37
 */

namespace app\controllers;


use backend\base\Controller;
use backend\models\InvoiceType;
use backend\models\OrderType;
use backend\models\PayMethod;

class ParamsController extends Controller
{

    public function actionPayMethod()
    {
        $model = new PayMethod();
        if (app()->request->isPost) {
            $data = app()->request->post('PayMethod');
            if ($model->saveData($data)) {
                return $this->success('保存成功');
            }
            return $this->fail('保存失败',$model->getErrors());
        }

        $list = $model->getList([]);

        return $this->render('pay-method', [
            'model' => $model,
            'list' => $list['list'],
            'pages' => $list['pages'],
            'statusList' => [
                PayMethod::STATUS_ACTIVE => '有效',
                PayMethod::STATUS_INACTIVE => '无效',
            ]
        ]);
    }

    public function actionOrderType()
    {

        $model = new OrderType();
        if (app()->request->isPost) {
            $data = app()->request->post('OrderType');
            if ($model->saveData($data)) {
                return $this->success('保存成功');
            }
            return $this->fail('保存失败');
        }

        $list = $model->getList([]);

        return $this->render('order-type', [
            'model' => $model,
            'list' => $list['list'],
            'pages' => $list['pages'],
            'statusList' => [
                OrderType::STATUS_ACTIVE => '有效',
                OrderType::STATUS_INACTIVE => '无效',
            ]
        ]);
    }

    public function actionInvoiceType()
    {
        $model = new InvoiceType();
        if (app()->request->isPost) {
            $data = app()->request->post('InvoiceType');
            if ($model->saveData($data)) {
                return $this->success('保存成功');
            }
            return $this->fail('保存失败',$model->getErrors());
        }

        $list = $model->getList([]);

        return $this->render('invoice-type', [
            'model' => $model,
            'list' => $list['list'],
            'pages' => $list['pages'],
            'statusList' => [
                InvoiceType::STATUS_ACTIVE => '有效',
                InvoiceType::STATUS_INACTIVE => '无效',
            ]
        ]);
    }
}