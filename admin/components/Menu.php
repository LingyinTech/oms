<?php


namespace lingyin\admin\components;


use lingyin\admin\logic\RoleLogic;

class Menu
{
    /**
     * @return array
     */
    public static function getMenuItems()
    {
        return (new RoleLogic())->getAccessMenuByUser(app()->user);
    }


}