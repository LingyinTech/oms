<?php


namespace lingyin\admin\models;

use lingyin\admin\base\ActiveRecord;

/**
 * Class UserInfo
 * @package backend\models
 * @property $user_id
 * @property $email
 * @property $partner_id
 */
class UserInfo extends ActiveRecord
{
    protected $snowflakePrimaryKey = false;

    public function rules()
    {
        return [
            [['user_id', 'email'], 'required'],
            ['email', 'email', 'message' => '邮箱格式不合法'],
        ];
    }

}