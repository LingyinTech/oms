<?php


namespace lingyin\admin\models\vo;

use lingyin\admin\logic\PartnerLogic;
use lingyin\admin\models\RoleUser;
use lingyin\admin\models\User;
use lingyin\admin\base\Model;

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
            $roleArr = array_map(
                function ($v) {
                    return intval($v);
                },
                explode(',', $this->role_id)
            );
            return $this->role_id = array_unique($roleArr);
        }

        return $this->role_id = [];
    }

    public function batchSaveRoleUser()
    {
        if ($this->validate()) {
            $model = new RoleUser();
            $result = $model->batchSaveData($this->user_id, $this->role_id);
            if (!$result) {
                $this->addErrors($model->getErrors());
            }
            return $result;
        }

        return false;
    }

    public function validate($attributeNames = null, $clearErrors = true)
    {
        $user = User::findOne($this->user_id);
        if (!$user || !PartnerLogic::checkPartnerId($user->current_partner_id)) {
            $this->addError('msg', '非法操作');
            return false;
        }

        return parent::validate($attributeNames, $clearErrors);
    }

}