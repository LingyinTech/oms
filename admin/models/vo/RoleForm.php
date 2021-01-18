<?php


namespace lingyin\admin\models\vo;

use lingyin\admin\logic\PartnerLogic;
use lingyin\admin\models\Partner;
use lingyin\admin\models\Role;
use lingyin\admin\base\Model;

class RoleForm extends Model
{

    public $id;
    public $name;
    public $remark;
    public $sort;
    public $status;
    public $partner_id;

    public function rules()
    {
        return [
            ['id', 'filter', 'filter' => 'intval', 'skipOnEmpty' => true],
            ['partner_id', 'exist', 'targetClass' => Partner::class, 'targetAttribute' => ['partner_id' => 'id'], 'skipOnEmpty' => true],
            ['sort', 'default', 'value' => 99],
            [['remark', 'name'], 'filter', 'filter' => 'trim'],
            ['name', 'required'],
            ['status', 'default', 'value' => Role::STATUS_INACTIVE],
            ['status', 'in', 'range' => [Role::STATUS_INACTIVE, Role::STATUS_DELETE, Role::STATUS_ACTIVE]],
        ];
    }

    public function saveRole()
    {
        if ($this->validate()) {
            $model = new Role();
            $data = [];
            foreach ($model->filterInputAttributes() as $attribute) {
                if (isset($this->{$attribute})) {
                    $data[$attribute] = $this->{$attribute};
                }
            }
            $data['partner_id'] = PartnerLogic::filterPartnerId($this->partner_id);
            if($model->saveData($data)) {
               return true;
            }
            $this->addErrors($model->getErrors());
        }

        return false;
    }

    public function validate($attributeNames = null, $clearErrors = true)
    {
        if (parent::validate($attributeNames, $clearErrors)) {
            if ($this->id) {
                $role = Role::findOne($this->id);
                if (!$role) {
                    $this->addError('msg', '操作失败，请稍后再试');
                    return false;
                }

                if (!PartnerLogic::checkPartnerId($role->partner_id)) {
                    $this->addError('msg','非法操作');
                    return false;
                }
            }
        }

        return true;
    }

}