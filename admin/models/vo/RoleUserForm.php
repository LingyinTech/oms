<?php


namespace lingyin\admin\models\vo;

use lingyin\admin\models\RoleUser;
use yii\base\Model;

class RoleUserForm extends Model
{

    public $user_id;
    public $role_id;

    public function rules()
    {
        return [
            [['user_id', 'role_id'], 'required'],
            ['role_id', 'filterRole']
        ];
    }

    public function filterRole($attribute, $params)
    {
        if ($this->role_id) {
            $roleArr = array_map(function ($v) {
                return intval($v);
            }, explode(',', $this->role_id));
            return implode(',', array_unique($roleArr));
        }
    }

    public function batchSaveRoleUser()
    {
        if ($this->validate()) {
            $roleArr = explode(',', $this->role_id);
            $model = new RoleUser();
            $result = $model->batchSaveData($this->user_id, $roleArr);
            if (!$result) {
                $this->addErrors($model->getErrors());
            }
            return $result;
        }

        return false;
    }

}