<?php


namespace lingyin\admin\controllers;


use lingyin\admin\base\Controller;
use lingyin\admin\logic\RoleLogic;
use lingyin\admin\models\Node;
use lingyin\admin\models\Role;
use lingyin\admin\models\RoleNode;
use lingyin\admin\models\vo\PartnerForm;
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
            'pages' => $list['pages'],
            'model' => $model,
            'statusList' => [
                Role::STATUS_INACTIVE => '未开放',
                Role::STATUS_ACTIVE => '启用',
                Role::STATUS_DELETE => '禁用',
            ],
            'partnerList' => (new PartnerForm())->getPartnerList(),
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
                $nodeIdStr = isset($data[$roleId]) ? implode(',', $data[$roleId]) : '';
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
            'pages' => $list['pages'],
            'model' => new RoleNodeForm(),
            'nodeList' => $nodeList,
            'nodeStatusList' => [
                Node::STATUS_ACTION => '动作',
                Node::STATUS_ELEMENT => '元素',
            ],
        ]);
    }

    public function actionSaveNode()
    {
        $model = new RoleNodeForm();
        $model->role_id = app()->request->post('role_id');
        $model->node_id = app()->request->post('node_id');
        if ($model->batchSaveRoleNode()) {
            return $this->success('保存成功');
        }
        return $this->format([
            'status' => 1,
            'msg' => '保存失败',
            'errors' => $model->getErrors(),
        ]);
    }

    public function actionUser()
    {
        return $this->render('user');
    }
}