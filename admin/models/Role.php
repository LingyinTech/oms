<?php


namespace lingyin\admin\models;

use lingyin\admin\base\ActiveRecord;

/**
 * Class Role
 * @package lingyin\admin\models
 * @property int $partner_id 合作伙伴ID
 */
class Role extends ActiveRecord
{
    //状态，0未开放，1删除，10开放
    const STATUS_INACTIVE = 0;
    const STATUS_DELETE = 1;
    const STATUS_ADMIN = 2;
    const STATUS_ACTIVE = 10;

    public function deleteCache()
    {
        return app()->cache->delete('admin:role');
    }
}