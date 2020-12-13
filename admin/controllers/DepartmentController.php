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
        $model = new Department();

        $list = $model->getList(['orderBy'=>'sort ASC,id DESC']);

        $model = new DepartmentForm();
        return $this->render('index', [
            'model' => $model,
            'list' => $list['list'],
            'pages' => $list['pages'],
        ]);
    }

    public function actionSave()
    {
        $model = new DepartmentForm();
        if ($model->load(app()->request->post()) && $model->saveDepartment()) {
            return $this->success('保存成功');
        }
        return $this->format([
            'status' => 1,
            'msg' => '保存失败',
            'errors' => $model->getErrors(),
        ]);
    }

    public function actionSelect()
    {
        $list = (new Department())->getAll([]);

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