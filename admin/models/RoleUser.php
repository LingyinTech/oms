<?php


namespace lingyin\admin\models;


use lingyin\admin\base\ActiveRecord;
use lingyin\admin\logic\PartnerLogic;
use yii\db\Exception;

class RoleUser extends ActiveRecord
{

    public function getAllRoleByUserIds($userIdArr)
    {
        $data = $this->setWhere(
            [
                'in' => ['user_id' => $userIdArr],
            ]
        )->asArray()->all();

        $result = [];
        if ($data) {
            foreach ($data as $item) {
                $result[$item['user_id']][] = $item['role_id'];
            }
        }

        return $result;
    }

    public function batchSaveData($userId, $roleArr)
    {
        $data = $this->getAllRoleByUserIds([$userId]);
        $oldRoleArr = [];
        if ($data && isset($data[$userId])) {
            $oldRoleArr = $data[$userId];
        }

        // 需删除的权限
        $deleteArr = array_diff($oldRoleArr, $roleArr);

        // 需要增加的权限
        $addArr = array_diff($roleArr, $oldRoleArr);

        if (empty($deleteArr) && empty($addArr)) {
            $this->addError('role_id', '没有修改任何权限');
            return false;
        }

        $partnerId = PartnerLogic::filterPartnerId();

        $trans = self::getDb()->beginTransaction();

        try {
            if (!empty($deleteArr)) {
                $deleteStr = implode("','", $deleteArr);
                $condition = "user_id = '{$userId}' AND role_id in ('{$deleteStr}') AND partner_id = {$partnerId}";
                self::getDb()->createCommand()->delete(self::tableName(), $condition)->execute();
            }

            if (!empty($addArr)) {
                $add = [];
                foreach ($addArr as $roleId) {
                    $add[] = [
                        'user_id' => $userId,
                        'role_id' => $roleId,
                        'partner_id' => $partnerId,
                    ];
                }
                self::getDb()->createCommand()->batchInsert(
                    self::tableName(),
                    ['user_id', 'role_id', 'partner_id'],
                    $add
                )->execute();
            }
            $trans->commit();
        } catch (Exception $e) {
            $trans->rollBack();
            $this->addError('role_id', $e->getMessage());
            return false;
        }

        return true;
    }
}