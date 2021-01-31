<?php


namespace lingyin\admin\models\vo;

use lingyin\admin\logic\PartnerLogic;
use lingyin\admin\models\Role;
use lingyin\admin\models\RoleNode;
use lingyin\admin\base\Model;

class RoleNodeForm extends Model
{

    public $role_id;
    public $node_id;

    public function rules()
    {
        return [
            ['role_id', 'required'],
            ['node_id', 'filterNode']
        ];
    }

    public function filterNode($attribute, $params)
    {
        if ($this->node_id) {
            $nodeArr = array_map(
                function ($v) {
                    return intval($v);
                },
                explode(',', $this->node_id)
            );
            return $this->node_id = array_unique($nodeArr);
        }

        return $this->node_id = [];
    }

    public function batchSaveRoleNode()
    {
        if ($this->validate()) {
            $model = new RoleNode();
            $result = $model->batchSaveData($this->role_id, $this->node_id);
            if (!$result) {
                $this->addErrors($model->getErrors());
            }
            return $result;
        }

        return false;
    }

    public function validate($attributeNames = null, $clearErrors = true)
    {
        $role = Role::findOne($this->role_id);
        if (!$role || !PartnerLogic::checkPartnerId($role->partner_id)) {
            $this->addError('msg', '非法操作');
            return false;
        }

        return parent::validate($attributeNames, $clearErrors);
    }

}