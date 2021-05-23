<?php


namespace lingyin\admin\models\vo;

use lingyin\admin\models\User;
use lingyin\admin\models\UserInfo;
use lingyin\admin\base\Model;
use yii\db\Exception;

class RegisterForm extends Model
{
    public $username;
    public $password;
    public $email;

    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            [['email', 'username', 'password'], 'required'],
            ['password', 'string', 'min' => 6],
            ['username', 'string', 'max' => 32],
            ['email', 'unique', 'targetClass' => User::class, 'message' => '邮箱已存在'],
        ];
    }

    /**
     * @return User|null
     * @throws \yii\base\Exception
     */
    public function register()
    {
        if ($this->validate()) {
            $user = new User();
            $user->email = $this->email;
            $user->setPassword($this->password);
            $trans = app()->db->beginTransaction();
            try {
                if ($user->save()) {
                    $userInfo = new UserInfo();
                    $userInfo->setShouldCheckPartnerSave(false);
                    $userInfo->user_id = $user->getId();
                    $userInfo->username = $this->username;
                    if ($userInfo->save()) {
                        $trans->commit();
                        return $user;
                    }
                    $trans->rollBack();
                }
            } catch (Exception $e) {
                $trans->rollBack();
            }
        }
        return null;
    }
}