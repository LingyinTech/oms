<?php


namespace lingyin\admin\models\vo;

use lingyin\admin\models\Role;
use yii\base\Model;

class RoleNodeForm extends Model
{

    public $role_id;
    public $node_id;

    public function rules()
    {
        return [
            [['role_id','node_id'], 'required'],
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