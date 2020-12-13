<?php


namespace lingyin\admin\models;


use lingyin\admin\base\ActiveRecord;
use lingyin\admin\logic\PartnerLogic;
use lingyin\admin\logic\RoleLogic;
use yii\base\InvalidConfigException;
use yii\db\Exception;

class RoleNode extends ActiveRecord
{

    /**
     * @param $roleIdArr
     * @return array
     * @throws \Throwable
     */
    public function getAllNodeByRoleIds($roleIdArr)
    {
        $data = $this->setWhere(
            [
                'in' => ['role_id' => $roleIdArr],
            ]
        )->asArray()->all();

        $result = [];
        if ($data) {
            foreach ($data as $item) {
                $result[$item['role_id']][] = $item['node_id'];
            }
        }

        return $result;
    }

    /**
     * @param $roleId
     * @param $nodeArr
     * @return bool
     * @throws \Throwable
     * @throws InvalidConfigException
     */
    public function batchSaveData($roleId, $nodeArr)
    {
        $data = $this->getAllNodeByRoleIds([$roleId]);
        $oldNodeArr = [];
        if ($data && isset($data[$roleId])) {
            $oldNodeArr = $data[$roleId];
        }

        // 当前用户拥有的全部权限
        $nodeList = (new RoleLogic())->getAccessNodeByUser(app()->user);
        $accessNodeArr = array_column($nodeList, 'id');

        // 需删除的权限
        $deleteNode = array_diff($oldNodeArr, $nodeArr);
        $deleteNode = array_intersect($deleteNode, $accessNodeArr);

        // 需要增加的权限
        $addNode = array_diff($nodeArr, $oldNodeArr);
        $addNode = array_intersect($addNode, $accessNodeArr);

        if (empty($deleteNode) && empty($addNode)) {
            $this->addError('node_id', '没有修改任何权限');
            return false;
        }

        $partnerId = PartnerLogic::filterPartnerId();

        $trans = self::getDb()->beginTransaction();

        try {
            if (!empty($deleteNode)) {
                $deleteStr = implode("','", $deleteNode);
                $condition = "role_id = '{$roleId}' AND node_id in ('{$deleteStr}') AND partner_id = {$partnerId}";
                self::getDb()->createCommand()->delete(self::tableName(), $condition)->execute();
            }

            if (!empty($addNode)) {
                $add = [];
                foreach ($addNode as $nodeId) {
                    $add[] = [
                        'role_id' => $roleId,
                        'node_id' => $nodeId,
                        'partner_id' => $partnerId,
                    ];
                }
                self::getDb()->createCommand()->batchInsert(
                    self::tableName(),
                    ['role_id', 'node_id', 'partner_id'],
                    $add
                )->execute();
            }
            $trans->commit();
        } catch (Exception $e) {
            $trans->rollBack();
            $this->addError('node_id', $e->getMessage());
            return false;
        }

        return true;
    }
}