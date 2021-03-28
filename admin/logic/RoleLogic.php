<?php


namespace lingyin\admin\logic;

use lingyin\admin\models\Node;
use lingyin\admin\models\RoleNode;
use lingyin\admin\models\RoleUser;
use yii\db\ActiveRecord;
use yii\web\User;

class RoleLogic
{

    public function getAccessNodeByUser($user, $view = false)
    {
        $params = [
            'in' => [
                'status' => [
                    Node::STATUS_ACTION,
                    Node::STATUS_ELEMENT,
                    Node::STATUS_VIEW,
                    Node::STATUS_MENU
                ]
            ],
        ];

        try {
            $supperAdmin = $user->getIdentity()->getSupperAdmin();
        } catch (\Throwable $e) {
            $supperAdmin = false;
        }

        if (!$supperAdmin) {
            // 这里可以加个缓存
            $roleList = (new RoleUser())->setWhere(
                [
                    'user_id' => $user->getId(),
                ]
            )->select('role_id')->asArray()->all();
            if (empty($roleList)) {
                return [];
            }

            $roleArr = array_column($roleList, 'role_id');
            $list = (new RoleNode())->setWhere(
                [
                    'in' => ['role_id' => $roleArr]
                ]
            )->select('node_id')->asArray()->all();
            if (empty($list)) {
                return [];
            }

            $nodeArr = array_column($list, 'node_id');

            $params['in']['id'] = $nodeArr;
        }

        $list = (new Node())->setWhere($params)->orderBy('sort ASC,pid ASC,id ASC')->asArray()->all();

        if ($view) {

            $list = array_column($list, null, 'id');

            $viewList = app()->viewConfig->getAccessViewList($user);
            foreach ($viewList as $item) {
                $node = [
                    'id' => 'view-' . $item['id'],
                    'pid' => $item['menu_id'],
                    'label' => $item['name'],
                    'url' => $item['pre_path'] . $item['id'],
                    'sort' => 99,
                    'status' => $item['is_menu'] ? Node::STATUS_MENU : Node::STATUS_ELEMENT,
                ];
                if (Node::STATUS_MENU == $node['status']) {
                    $list[$item['menu_id']]['status'] = Node::STATUS_MENU;
                }
                $list[$node['id']] = $node;
            }
        }

        return array_values($list);
    }

    /**
     * @param User $user
     * @param array $filterStatus
     * @param bool $view 是否包含视图
     * @return array|ActiveRecord[]
     */
    public function getAccessTreeByUser(
        $user,
        $filterStatus = [Node::STATUS_ACTION, Node::STATUS_ELEMENT, Node::STATUS_VIEW, Node::STATUS_MENU],
        $view = false
    ) {
        $list = $this->getAccessNodeByUser($user, $view);

        return $this->list2Tree($list, $filterStatus);
    }

    /**
     * 获取有权限的菜单
     * @param User $user
     * @param bool $view 是否包含视图
     * @return array
     */
    public function getAccessMenuByUser($user, $view = false)
    {
        return $this->getAccessTreeByUser($user, [Node::STATUS_MENU], $view);
    }

    protected function list2Tree($list, $filterStatus = null)
    {
        if (empty($list)) {
            return [];
        }

        $current = '/' . app()->getRequest()->getPathInfo();

        $tree = [];

        $refer = [];
        foreach ($list as $key => $data) {
            if ($data['url'] == $current) {
                $this->treeActive($data['pid'], $list);
            }
            $refer[$data['id']] = &$list[$key];
        }

        foreach ($list as $key => $data) {
            if (!in_array($data['status'], $filterStatus)) {
                unset($list[$key]);
                continue;
            }

            if (0 == $data['pid']) {
                $tree[] = &$list[$key];
            } elseif (isset($refer[$data['pid']])) {
                $parent = &$refer[$data['pid']];
                $parent['items'][] = &$list[$key];
            }
        }

        return $tree;
    }

    protected function treeActive($current, &$list)
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