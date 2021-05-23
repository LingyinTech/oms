<?php


namespace lingyin\admin\models;

use lingyin\admin\base\ActiveRecord;

/**
 * Class UserInfo
 * @package backend\models
 * @property $user_id
 * @property $username
 * @property $partner_id
 */
class UserInfo extends ActiveRecord
{
    protected $snowflakePrimaryKey = false;

    public function rules()
    {
        return [
            [['user_id', 'username'], 'required'],
        ];
    }

}