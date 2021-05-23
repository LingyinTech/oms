<?php


namespace lingyin\admin\components;

use lingyin\admin\logic\RoleLogic;
use Yii;
use yii\base\ActionFilter;
use yii\web\ForbiddenHttpException;
use yii\web\User;

class AccessControl extends ActionFilter
{

    public $allowActions = [];

    public $supperAdmin = [];

    /**
     * @inheritdoc
     * @throws ForbiddenHttpException
     */
    public function beforeAction($action)
    {
        $user = app()->accessCheck->getUser();

        if (!$user->getIsGuest()) {
            if (in_array($user->getIdentity()->getEmail(), $this->supperAdmin)) {
                $user->getIdentity()->setSupperAdmin(true);
                return true;
            }

            $pathInfo = app()->getRequest()->getPathInfo();
            if(app()->accessCheck->checkPermission($pathInfo)) {
                return true;
            }
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

        $user = app()->accessCheck->getUser();
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
            } elseif ($uniqueId === $route) {
                return false;
            }
        }

        return true;
    }

}