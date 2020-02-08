<?php


namespace lingyin\admin\controllers;


use lingyin\admin\base\Controller;
use lingyin\admin\logic\RoleLogic;
use lingyin\admin\models\Node;
use lingyin\admin\models\Role;
use lingyin\admin\models\RoleNode;
use lingyin\admin\models\vo\RoleForm;
use lingyin\admin\models\vo\RoleNodeForm;

class RoleController extends Controller
{

    public function actionIndex()
    {
        $model = new Role();

        $list = $model->getList([]);

        $model = new RoleForm();

        return $this->render('index', [
            'list' => $list['list'],
            'model' => $model,
            'statusList' => [
                Role::STATUS_INACTIVE => '未开放',
                Role::STATUS_ACTIVE => '启用',
                Role::STATUS_DELETE => '禁用',
            ]
        ]);
    }

    public function actionSave()
    {
        $model = new RoleForm();
        if ($model->load(app()->request->post()) && $model->saveRole()) {
            return $this->success('保存成功');
        }
        return $this->format([
            'status' => 1,
            'msg' => '保存失败',
            'errors' => $model->getErrors(),
        ]);
    }

    public function actionNode()
    {
        if (app()->getRequest()->isAjax) {
            $roleId = app()->getRequest()->get('role_id');
            if ($roleId) {
                $data = (new RoleNode())->getAllNodeByRoleIds([$roleId]);
                $nodeIdStr = isset($data[$roleId]) ? implode(',', $data) : '';
                return $this->format($nodeIdStr);
            }
            return $this->fail('非法请求');
        }

        $list = (new Role())->getList([
            'status' => Role::STATUS_ACTIVE
        ]);

        $nodeList = (new RoleLogic())->getAccessNodeByUser(app()->user);

        return $this->render('node', [
            'list' => $list['list'],
            'model' => new RoleNodeForm(),
            'nodeList' => $nodeList,
            'nodeStatusList' => [
                Node::STATUS_ACTION => '动作',
                Node::STATUS_ELEMENT => '元素',
            ],
        ]);
    }

    public function actionUser()
    {
        return $this->render('node');
    }
}