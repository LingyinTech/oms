<?php


namespace lingyin\admin\models;


use lingyin\admin\base\ActiveRecord;

class RoleNode extends ActiveRecord
{
    public function getAllNodeByRoleId($roleId)
    {
        $data = $this->setWhere([
            'role_id' => $roleId,
        ])->asArray()->all();

        if ($data) {
            return array_column($data, 'role_id');
        }

        return [];
    }
}