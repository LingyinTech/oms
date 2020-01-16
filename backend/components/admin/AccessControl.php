<?php


namespace backend\components\admin;


use Yii;
use yii\base\ActionFilter;
use yii\web\ForbiddenHttpException;
use yii\web\User;

class AccessControl extends ActionFilter
{

    /**
     * @var User User for check access.
     */
    private $user = 'user';

    public $allowActions = [];

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        return true;
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

}