<?php


namespace lingyin\admin\models;

use lingyin\admin\base\ActiveRecord;
use lingyin\admin\logic\PartnerLogic;

/**
 * Class Role
 * @package lingyin\admin\models
 * @property integer $partner_id 合作伙伴ID
 */
class Role extends ActiveRecord
{
    //状态，0未开放，1删除，10开放
    const STATUS_INACTIVE = 0;
    const STATUS_DELETE = 1;
    const STATUS_ACTIVE = 10;

    public function deleteCache()
    {
        return app()->cache->delete('admin:role');
    }

    public function getList($params)
    {
        PartnerLogic::setPartnerId($params);
        return parent::getList($params);
    }

    public function getAll($params)
    {
        PartnerLogic::setPartnerId($params);
        return parent::getAll($params);
    }

    public function beforeSave($insert)
    {
        if (!$insert && !PartnerLogic::checkPartnerId($this->partner_id)) {
            $this->addError('msg', '非法操作');
            return false;
        }

        return parent::beforeSave($insert);
    }
}