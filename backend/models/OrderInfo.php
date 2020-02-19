<?php
/**
 * Created by PhpStorm.
 * User: huanjin
 * Date: 2018/5/18
 * Time: 0:20
 */

namespace backend\models;


use backend\base\ActiveRecord;
use yii\db\Exception;

/**
 * Class OrderInfo
 * @package backend\modules\orderFlow\models
 * @property int $id 订单ID
 * @property int $order_time 下单时间
 * @property int $plan_time 安排时间
 * @property string $order_sn
 * @property int is_delete 是否删除
 */
class OrderInfo extends ActiveRecord
{

    /**
     * 所有订单
     * 默认查询未删除订单
     *
     * @param array $params
     * @param array | string $fields
     * @return array|false
     */
    public function getList($params = [], $fields = '*')
    {
        !isset($params['is_delete']) && $params['is_delete'] = 0;
        return parent::getList($params, $fields);
    }

    public function saveOrder()
    {
        $trans = app()->db->beginTransaction();
        try {
            $nowTime = time();
            $orderData = app()->request->post('OrderInfo');
            if (empty($orderData['id'])) {
                unset($orderData['id']);
            }
            $orderData['order_time'] = empty($orderData['plan_time']) ? $nowTime : strtotime($orderData['order_time']);
            $orderData['plan_time'] = empty($orderData['plan_time']) ? 0 : strtotime($orderData['plan_time']);
            empty($orderData['user_id']) && $orderData['user_id'] = app()->getUser()->getId();
            if (!empty($orderData['id']) && $model = self::findOne($orderData['id'])) {
                $model->setAttributes($orderData, false);
                if (!$model->save()) {
                    $trans->rollBack();
                    return false;
                }
            } else {
                unset($orderData['id']);
                $model = $this;
                $model->isNewRecord = true;
                $model->setAttributes($orderData, false);
                if (!$model->validate()) {
                    $trans->rollBack();
                    return $model->getErrors();
                }
                if (!$model->save()) {
                    $trans->rollBack();
                    return false;
                }
            }
            $orderGoodsList = app()->request->post('skuList');
            if (!empty($orderGoodsList)) {
                $orderGoodsModel = new OrderGoods();
                foreach ($orderGoodsList as $orderGoods) {
                    if (empty($orderGoods['goods_id'])) {
                        continue;
                    }
                    $orderGoods['order_id'] = $model->id;
                    if (!$orderGoodsModel->saveGoods($orderGoods)) {
                        $trans->rollBack();
                        return false;
                    }
                }
            }
            $trans->commit();
            return true;
        } catch (Exception $e) {
            $trans->rollBack();
            return $e->getMessage();
        }
    }

    public function beforeSave($insert)
    {
        $nowTime = time();
        if ($insert) {
            $this->setAttributes([
                'add_time' => $nowTime,
                'order_sn' => date('YmdHi') . rand(10, 99),
                'up_time' => $nowTime,
            ], false);
        } else {
            $this->setAttributes([
                'up_time' => $nowTime,
            ], false);
        }
        return parent::beforeSave($insert);
    }

}