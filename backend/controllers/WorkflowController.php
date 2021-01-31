<?php


namespace app\controllers;


use backend\base\Controller;

class WorkflowController extends Controller
{

    public function actionIndex()
    {
        $this->render('index', []);
    }

}