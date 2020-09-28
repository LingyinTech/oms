<?php

namespace lingyin\admin\models;

use lingyin\admin\base\ActiveRecord;
use lingyin\admin\logic\PartnerLogic;

/**
 * Class Department
 * @package lingyin\admin\models
 * @property int $partner_id 合作伙伴ID
 */
class Department extends ActiveRecord
{
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