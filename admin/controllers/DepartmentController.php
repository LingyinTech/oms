<?php


namespace lingyin\admin\controllers;


use lingyin\admin\base\Controller;
use lingyin\admin\models\Department;
use lingyin\admin\models\vo\DepartmentForm;
use lingyin\traits\ListTreeTrait;

class DepartmentController extends Controller
{
    use ListTreeTrait;

    public function actionIndex()
    {
        $model = new DepartmentForm();
        return $this->render('index', [
            'model' => $model,
        ]);
    }

    public function actionSelect()
    {
        $list = (new Department())->getAll(['status' => 1]);

        $list = $this->list2Tree($list);

        $this->layout = '//main-login';
        return $this->render('select', [
            'tree' => $this->treeToHtml($list),
        ]);
    }

    public function treeToHtml($list)
    {
        return $this->renderPartial('tree', [
            'list' => $list,
            'renderer' => $this,
        ]);
    }
}