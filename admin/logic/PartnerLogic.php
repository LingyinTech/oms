<?php


namespace lingyin\admin\logic;


class PartnerLogic
{

    /**
     * @param integer $partnerId
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

    public static function setPartnerId(&$params,$field = 'partner_id') {
        if (!app()->user->getIdentity()->getSupperAdmin()) {
            $params[$field] = app()->user->getIdentity()->partner_id;
        }
    }

}