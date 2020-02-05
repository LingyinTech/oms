<?php


namespace lingyin\admin\models;


use lingyin\admin\base\ActiveRecord;

class RoleUser extends ActiveRecord
{
    /**
     * 获取有权限的菜单
     * @param $userId
     * @return array
     */
    public function getAccessMenu($userId)
    {
        $list = $this->setWhere([
            'alias' => 'ru',
            'join' => ['role_node rn' => 'rn.role_id = ru.role_id'],
            'ru.user_id' => $userId,
        ])->select('rn.node_id')->asArray()->all();

        if (empty($list)) return [];

        $nodeArr = array_column($list, 'node_id');

        $nodeModel = new Node();
        return $nodeModel->setWhere([
            'status' => Node::STATUS_MENU,
        ])->asArray()->all();
    }
}