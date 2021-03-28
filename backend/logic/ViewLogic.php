<?php


namespace backend\logic;


use backend\models\ViewConfig;
use yii\web\View;

class ViewLogic
{

    protected $accessViewList = [];

    /**
     * 公司管理员可以查看所有视图，其他人只能查看公司共公视图或者自己建的视图
     * @param $user
     * @return array
     * @throws \Throwable
     */
    public function getAccessViewList($user)
    {
        $userId = $user->getId();

        if (isset($this->accessViewList[$userId])) {
            return $this->accessViewList[$userId];
        }

        try {
            $supperAdmin = $user->getIdentity()->getSupperAdmin();
        } catch (\Throwable $e) {
            $supperAdmin = false;
        }

        $companyAdmin = false;

        $viewModel = new ViewConfig();

        $condition = ['in' => ['status' => [ViewConfig::STATUS_ACTIVE, ViewConfig::STATUS_PRIVATE]]];
        $viewList = $viewModel->getAll($condition);
        $list = [];
        if (!$supperAdmin && !$companyAdmin) {
            foreach ($viewList as $item) {
                if (ViewConfig::STATUS_ACTIVE == $item['status']) {
                    $list[] = $item;
                    continue;
                }

                if ($userId == $item['user_id']) {
                    $list[] = $item;
                    continue;
                }
            }
        } else {
            $list = $viewList;
        }

        $systemList = $viewModel->assignDb(
            'db',
            function ($model) {
                return $model->getAll(['partner_id' => 0, 'status' => ViewConfig::STATUS_ACTIVE]);
            }
        );

        $sysViewArr = array_column($list, 'sys_view_id');
        foreach ($systemList as $item) {
            if (!in_array($item['sys_view_id'], $sysViewArr)) {
                array_unshift($list, $item);
            }
        }

        return $this->accessViewList[$userId] = $list;
    }

    public function getActiveView($viewId, $user)
    {
        $userId = $user->getId();
        if (!isset($this->accessViewList[$userId])) {
            $this->getAccessViewList($user);
        }

        foreach ($this->accessViewList[$userId] as $view) {
            if ($viewId == $view['id']) {
                return $view;
            }
        }

        return false;
    }
}