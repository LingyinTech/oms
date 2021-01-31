<?php


namespace lingyin\admin\components;

use lingyin\admin\logic\RoleLogic;
use yii\web\User;

class AccessCheck
{
    protected $permissionList = [];

    public function checkPermission($action)
    {
        $user = $this->getUser();
        if ($user->getIsGuest()) {
            return false;
        }

        if ($user->getIdentity()->getSupperAdmin()) {
            return true;
        }

        if (!isset($this->permissionList[$user->getId()])) {
            $this->permissionList[$user->getId()] = (new RoleLogic())->getAccessNodeByUser($user);
        }

        foreach ($this->permissionList[$user->getId()] as $node) {
            if ($action === ltrim($node['url'], '/')) {
                return true;
            }
        }
    }

    public function checkViewPermission($view_id)
    {

    }

    /**
     * @return User
     */
    public function getUser()
    {
        return app()->getUser();
    }
}