<?php


namespace app\controllers;


use backend\base\Controller;
use backend\models\vo\OrderForm;
use backend\models\vo\TemplateForm;
use Yii;
use yii\web\ForbiddenHttpException;

class OrderController extends Controller
{

    public function actionIndex($viewId = 0)
    {
        if (!empty($viewId)) {
            $viewForm = app()->viewConfig->getActiveView($viewId, app()->user);
            if (empty($viewForm)) {
                throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
            }

            $condition = json_decode($viewForm['condition_text'],true);
        } else {
            $condition = [];
        }

        $orderTypeList = [];//(new OrderType())->getCache();
        $payMethodList = [];//(new PayMethod())->getCache();

        return $this->render(
            'index',
            [
                'orderTypeList' => $orderTypeList,
                'payMethodList' => $payMethodList,
            ]
        );
    }

    public function actionAdd()
    {
        $model = new OrderForm();
        $path = app()->request->getPathInfo();
        $fieldGroup = (new TemplateForm())->getTemplateByPath($path);

        return $this->render(
            'add',
            [
                'model' => $model,
                'fieldGroup' => $fieldGroup,
                'orderTypeList' => [],
                'payMethodList' => [],
                'invoiceTypeList' => [],
            ]
        );
    }
}