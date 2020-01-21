<?php


namespace backend\models;


use yii\db\ActiveRecord;

/**
 * Class UserInfo
 * @package backend\models
 * @property $user_id
 * @property $email
 */
class UserInfo extends ActiveRecord
{
    public static function tableName()
    {
        return 'user_info';
    }

    public function rules()
    {
        return [
            [['user_id','email'], 'required'],
            ['email','email','message' => '用户名重复'],
        ];
    }
}