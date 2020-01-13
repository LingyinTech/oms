<?php


namespace backend\base;


use Yii;

class Controller extends \yii\web\Controller
{


    public function beforeAction($action)
    {
        $controller_id = app()->controller->id;
        $action_id = app()->controller->action->id;

        if () {

            return parent::beforeAction($action);
        }

        return false;
    }

}