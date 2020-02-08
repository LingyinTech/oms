<?php


namespace lingyin\admin\components;

use Yii;
use yii\base\ActionFilter;
use yii\web\ForbiddenHttpException;
use yii\web\User;

class AccessControl extends ActionFilter
{

    public $allowActions = [];

    public $supperAdmin = [];

    /**
     * @return User
     */
    public function getUser()
    {
        return app()->getUser();
    }

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        $user = $this->getUser();

        if (!$user->getIsGuest()) {
            if (in_array($user->getIdentity()->getUsername(), $this->supperAdmin)) {
                $user->getIdentity()->setSupperAdmin(true);
                return true;
            }

            $actionId = $action->getUniqueId();
            $pathInfo = app()->getRequest()->getPathInfo();

        }

        $this->denyAccess($user);
    }




    /**
     * @param User $user
     * @throws ForbiddenHttpException
     */
    protected function denyAccess($user)
    {
        if ($user->getIsGuest()) {
            $user->loginRequired();
        } else {
            throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
        }
    }

    protected function isActive($action)
    {
        $uniqueId = $action->getUniqueId();
        if ($uniqueId === Yii::$app->getErrorHandler()->errorAction) {
            return false;
        }

        $user = $this->getUser();
        if ($user->getIsGuest()) {
            $loginUrl = null;
            if (is_array($user->loginUrl) && isset($user->loginUrl[0])) {
                $loginUrl = $user->loginUrl[0];
            } elseif (is_string($user->loginUrl)) {
                $loginUrl = $user->loginUrl;
            }
            if (!is_null($loginUrl) && trim($loginUrl, '/') === $uniqueId) {
                return false;
            }
        }

        foreach ($this->allowActions as $route) {
            if (substr($route, -1) === '*') {
                $route = rtrim($route, "*");
                if ($route === '' || strpos($uniqueId, $route) === 0) {
                    return false;
                }
            } else {
                if ($uniqueId === $route) {
                    return false;
                }
            }
        }

        return true;
    }

}