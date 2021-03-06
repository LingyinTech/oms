<?php


namespace lingyin\admin\controllers;


use lingyin\admin\base\Controller;
use lingyin\admin\logic\PartnerLogic;
use lingyin\admin\models\User;
use lingyin\admin\models\UserInfo;
use lingyin\admin\models\dto\UserView;
use lingyin\admin\models\vo\DepartmentForm;
use lingyin\admin\models\vo\PartnerForm;
use lingyin\admin\models\vo\PasswordForm;
use lingyin\admin\models\vo\UserForm;

class UserController extends Controller
{

    public function actionIndex()
    {
        $model = new UserForm();

        $list = $model->getList([]);

        $viewData = [
            'list' => $list['list'],
            'pages' => $list['pages'],
            'statusList' => [
                User::STATUS_ACTIVE => '正常',
                User::STATUS_INACTIVE => '未激活',
                User::STATUS_DELETE => '禁用',
            ],
        ];

        if (app()->user->getIdentity()->getSupperAdmin()) {
            $viewData['partnerList'] = (new PartnerForm())->getPartnerList();
        }

        return $this->render('index', $viewData);
    }

    public function actionBatchAdd()
    {
        return $this->render('batch-add');
    }

    public function actionAdd()
    {
        $model = new UserForm();

        if (app()->request->isPost) {
            if ($model->load(app()->request->post()) && $model->saveUser()) {
                return $this->success('保存成功');
            }

            $errors = $model->getErrors();

            return $this->format(
                [
                    'status' => 1,
                    'msg' => isset($errors['msg']) ? current($errors['msg'])
                        : '保存失败',
                    'errors' => $errors,
                ]
            );
        }


        if ($id = app()->request->get('id')) {
            $model->initData($id);
        }
        return $this->render(
            'add',
            [
                'model' => $model,
                'statusList' => [
                    User::STATUS_ACTIVE => '正常',
                    User::STATUS_INACTIVE => '未激活',
                    User::STATUS_DELETE => '禁用',
                ],
                'departmentList' => (new DepartmentForm())->getDepartmentList(),
                'partnerList' => (new PartnerForm())->getPartnerList(),
            ]
        );
    }

    public function actionPassword()
    {
        $model = new PasswordForm();

        if (app()->request->isPost) {
            if ($model->load(app()->request->post()) && $model->setPassword()) {
                return $this->success('设置成功');
            }
            return $this->fail('设置失败', $model->getErrors());
        }

        $userId = app()->request->get('id', 0);
        if (!$userId || !User::findOne($userId)) {
            // 这里需要修改一下
            return $this->render(
                '/site/error',
                [
                    'name' => '非法操作',
                    'message' => '请选择需操作的用户',
                ]
            );
        }

        $model->user_id = $userId;

        $this->layout = '//main-login';
        return $this->render(
            'password',
            [
                'model' => $model,
            ]
        );
    }
}