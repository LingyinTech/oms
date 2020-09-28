<?php


namespace lingyin\admin\logic;


class PartnerLogic
{

    public static function checkPartnerId($partnerId)
    {
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
    public static function filterPartnerId($partnerId)
    {
        if (app()->user->getIdentity()->getSupperAdmin() && $partnerId) {
            return $partnerId;
        }

        return app()->user->getIdentity()->partner_id;
    }

    public static function setPartnerId(&$params, $field = 'partner_id')
    {
        try {
            if (!app()->user->getIdentity()->getSupperAdmin()) {
                $params[$field] = app()->user->getIdentity()->partner_id;
            }
        } catch (\Throwable $e) {
        }
    }

}