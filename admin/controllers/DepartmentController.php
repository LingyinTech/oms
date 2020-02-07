<?php


namespace lingyin\admin\controllers;


use lingyin\admin\base\Controller;

class DepartmentController extends Controller
{
    public function actionIndex()
    {

        return $this->render('index');
    }
}