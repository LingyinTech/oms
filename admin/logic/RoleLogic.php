<?php


namespace lingyin\admin\logic;


use lingyin\admin\models\Node;
use lingyin\admin\models\RoleUser;
use yii\db\ActiveRecord;
use yii\web\User;

class RoleLogic
{

    /**
     * @param User $user
     * @param array $filterStatus
     * @return array|ActiveRecord[]
     */
    public function getAccessNodeByUser($user, $filterStatus = [Node::STATUS_ACTION, Node::STATUS_ELEMENT, Node::STATUS_MENU])
    {

        $params = [
            'in' => ['status' => [Node::STATUS_ACTION, Node::STATUS_ELEMENT, Node::STATUS_MENU]],
        ];

        try {
            $supperAdmin = $user->getIdentity()->getSupperAdmin();
        } catch (\Throwable $e) {
            $supperAdmin = false;
        }

        if (!$supperAdmin) {
            $list = (new RoleUser())->setWhere([
                'alias' => 'ru',
                'join' => ['role_node rn' => 'rn.role_id = ru.role_id'],
                'ru.user_id' => $user->getId(),
            ])->select('rn.node_id')->asArray()->all();

            if (empty($list)) return [];

            $nodeArr = array_column($list, 'node_id');

            $params['in']['id'] = $nodeArr;
        }

        $list = (new Node())->setWhere($params)->orderBy('sort ASC,pid ASC,id ASC')->asArray()->all();

        return $this->list2Tree($list, $filterStatus);
    }

    /**
     * 获取有权限的菜单
     * @param User $user
     * @return array
     */
    public function getAccessMenuByUser($user)
    {
        return $this->getAccessNodeByUser($user, [Node::STATUS_MENU]);
    }

    public function list2Tree($list, $filterStatus = null)
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
            } else {
                if (isset($refer[$data['pid']])) {
                    $parent = &$refer[$data['pid']];
                    $parent['items'][] = &$list[$key];
                }
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