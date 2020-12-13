<?php

namespace lingyin\admin\logic;

/**
 * 合作伙伴校验
 * Class PartnerLogic
 * @package lingyin\admin\logic
 */
class PartnerLogic
{

    /**
     * 较验当前操作是否合法
     * @param $partnerId
     * @return bool
     * @throws \Throwable
     */
    public static function checkPartnerId($partnerId)
    {
        if (!app()->user->getIdentity()) {
            return false;
        }

        if (app()->user->getIdentity()->getSupperAdmin()) {
            return true;
        }

        if ($partnerId === app()->user->getIdentity()->partner_id) {
            return true;
        }

        return false;
    }

    /**
     * @param int $partnerId
     * @return mixed
     * @throws \Throwable
     */
    public static function filterPartnerId($partnerId = 0)
    {
        if (app()->user->getIdentity()->getSupperAdmin() && $partnerId) {
            return $partnerId;
        }

        return app()->user->getIdentity()->partner_id;
    }

    /**
     * 填加 partner_id 参数
     * @param $params
     * @param string $field
     * @throws \Throwable
     */
    public static function setPartnerId(&$params, $field = 'partner_id')
    {
        if (!app()->user->getIdentity()) {
            $params[$field] = 'error';
            return;
        }

        if (!app()->user->getIdentity()->getSupperAdmin()) {
            $params[$field] = app()->user->getIdentity()->current_partner_id;
        }
    }

}