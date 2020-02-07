<?php

namespace lingyin\admin\controllers;

use lingyin\admin\base\Controller;
use lingyin\admin\models\Node;
use lingyin\admin\models\vo\NodeForm;

class NodeController extends Controller
{

    public function actionIndex()
    {
        $model = new Node();

        $list = $model->getList([]);

        return $this->render('index', [
            'model' => $model,
            'list' => $list['list'],
            'pages' => $list['pages'],
            'statusList' => [
                Node::STATUS_INACTIVE => '未开放',
                Node::STATUS_ACTION => '动作',
                Node::STATUS_ELEMENT => '元素',
                Node::STATUS_MENU => '菜单',
            ],
        ]);
    }

    public function actionAdd()
    {
        $model = new NodeForm();
        if ($id = app()->getRequest()->get('id')) {
            $model->initData($id);
        }
        return $this->render('add', [
            'model' => $model,
            'action' => '添加菜单'
        ]);
    }

    public function actionDelete()
    {
        $id = app()->getRequest()->post('id');
        if ($id) {
            $child = Node::findOne(['pid' => $id]);
            if ($child) {
                return $this->fail('当前菜单下有子菜单，不允许删除');
            }

            if (!$model = Node::findOne($id)) {
                return $this->fail('菜单不存在');
            }

            if ($model->delete()) {
                return $this->success('删除成功');
            }

            return $this->fail('删除失败');
        }

        return $this->fail('非法请求');
    }


    public function actionSave()
    {
        $model = new NodeForm();
        if ($model->load(app()->request->post()) && $model->saveNode()) {
            return $this->success('保存成功');
        }
        return $this->format([
            'status' => 1,
            'msg' => '保存失败',
            'errors' => $model->getErrors(),
        ]);
    }
}
