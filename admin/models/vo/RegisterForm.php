<?php


namespace lingyin\admin\models\vo;

use backend\models\UserInfo;
use lingyin\admin\models\User;
use Yii;
use yii\base\Model;

class RegisterForm extends Model
{
    public $username;
    public $password;
    public $email;

    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            [['email','username', 'password'], 'required'],
            ['password', 'string', 'min' => 6],
            ['username', 'string', 'max' => 32],
            ['username', 'unique', 'targetClass' => User::class, 'message' => '用户名重复'],
        ];
    }

    /**
     * @return User|null
     * @throws \yii\base\Exception
     * @throws \yii\db\Exception
     */
    public function register()
    {
        if ($this->validate()) {
            $user = new User();

            $user->username = $this->username;
            $user->setPassword($this->password);
            $trans = Yii::$app->db->beginTransaction();
            if ($user->save()) {
                $userInfo = new UserInfo();
                $userInfo->user_id = $user->getId();
                $userInfo->email = $this->email;
                if ($userInfo->save()) {
                    $trans->commit();
                    return $user;
                }
            }

            $trans->rollBack();
        }
        return null;
    }
}