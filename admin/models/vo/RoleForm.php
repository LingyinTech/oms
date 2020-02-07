<?php


namespace lingyin\admin\models\vo;

use lingyin\admin\models\Role;
use yii\base\Model;

class RoleForm extends Model
{

    public $id;
    public $name;
    public $remark;
    public $sort;
    public $status;

    public function rules()
    {
        return [
            ['id', 'filter', 'filter' => 'intval', 'skipOnEmpty' => true],
            ['sort','default','value' => 99],
            [['remark','name'], 'filter', 'filter' => 'trim'],
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
            return $model->saveData($data);
        }

        return false;
    }

}