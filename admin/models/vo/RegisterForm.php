<?php


namespace lingyin\admin\models\vo;

use lingyin\admin\models\User;
use lingyin\admin\models\UserInfo;
use Yii;
use yii\base\Model;
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
            ['username', 'unique', 'targetClass' => User::class, 'message' => '用户名重复'],
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

            $user->username = $this->username;
            $user->setPassword($this->password);
            $trans = Yii::$app->db->beginTransaction();
            try {
                if ($user->save()) {
                    $userInfo = new UserInfo();
                    $userInfo->user_id = $user->getId();
                    $userInfo->email = $this->email;
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