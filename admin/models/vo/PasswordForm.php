<?php


namespace lingyin\admin\models\vo;

use lingyin\admin\models\User;
use yii\base\Model;

class PasswordForm extends Model
{

    public $user_id;
    public $password;
    public $confirm_password;

    public function rules()
    {
        return [
            ['user_id', 'filter', 'filter' => 'intval', 'skipOnEmpty' => true],
            [['password', 'confirm_password'], 'required'],
            [['password'], 'string', 'min' => 6],
            ['confirm_password', 'compare', 'compareAttribute' => 'password', 'message' => '两次输入密码不一致'],
        ];
    }

    public function modifyPassword()
    {
        if ($this->validate()) {
            $model = User::findOne(app()->user->getId());
            $model->setPassword($this->password);
            return $model->save();
        }

        return false;
    }

    public function setPassword()
    {
        if ($this->validate()) {
            $model = User::findOne($this->user_id);
            $model->setPassword($this->password);
            return $model->save();
        }

        return false;
    }
}