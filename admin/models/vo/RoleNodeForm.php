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
            $nodeArr = array_map(function ($v) {
                return intval($v);
            }, explode(',', $this->node_id));
            return implode(',', array_unique($nodeArr));
        }
    }

    public function batchSaveRoleNode()
    {
        if ($this->validate()) {
            $nodeArr = explode(',', $this->node_id);
            $model = new RoleNode();
            $result = $model->batchSaveData($this->role_id, $nodeArr);
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