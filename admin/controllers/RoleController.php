<?php


namespace lingyin\admin\controllers;


use lingyin\admin\base\Controller;
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
                $data = (new RoleNode())->getAllNodeByRoleId($roleId);
                return $this->format(implode(',', $data));
            }
            return $this->fail('非法请求');
        }

        $model = new Role();

        $list = $model->getList([
            'status' => Role::STATUS_ACTIVE
        ]);

        return $this->render('node', [
            'list' => $list['list'],
            'model' => new RoleNodeForm(),
        ]);
    }

    public function actionUser()
    {
        return $this->render('node');
    }
}