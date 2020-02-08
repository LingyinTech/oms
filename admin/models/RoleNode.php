<?php


namespace lingyin\admin\models;


use lingyin\admin\base\ActiveRecord;

class RoleNode extends ActiveRecord
{
    public function getAllNodeByRoleIds($roleIdArr)
    {
        $data = $this->setWhere([
            'in' => ['role_id' => $roleIdArr],
        ])->asArray()->all();

        if ($data) {
            return array_column($data, 'node_id', 'role_id');
        }

        return [];
    }
}