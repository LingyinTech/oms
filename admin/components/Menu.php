<?php


namespace lingyin\admin\components;


use lingyin\admin\models\Node;
use lingyin\admin\models\RoleUser;

class Menu
{
    /**
     * @return array
     */
    public static function getMenuItems()
    {
        $userId = app()->user->getId();

        $list = (new RoleUser())->getAccessMenu($userId);

        return self::list2Tree($list);
    }

    protected static function list2Tree($list)
    {
        if (empty($list)) {
            return [];
        }

        $current = '/' . app()->getRequest()->getPathInfo();

        $tree = [];

        $refer = [];
        foreach ($list as $key => $data) {
            if ($data['url'] == $current) {
                self::treeActive($data['pid'], $list);
            }
            $refer[$data['id']] = &$list[$key];
        }

        foreach ($list as $key => $data) {
            if (0 == $data['pid']) {
                $tree[] = &$list[$key];
            } else {
                if (isset($refer[$data['pid']])) {
                    $parent = &$refer[$data['pid']];
                    $parent['items'][] = &$list[$key];
                }
            }
        }

        return $tree;
    }

    protected static function treeActive($current, &$list)
    {
        foreach ($list as $key => $value) {
            if ($value['id'] == $current) {
                $list[$key]['active'] = true;
                if (!empty($current = $value['pid'])) {
                    self::treeActive($current, $list);
                }
                break;
            }
        }
    }
}