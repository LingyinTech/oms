<?php


namespace backend\models\vo;


use backend\base\Model;
use backend\models\ViewConfig;

class ViewConfigForm extends Model
{
    public $id;
    public $name;
    public $field_text;
    public $condition_text;
    public $status;
    public $remark;

    public function rules()
    {
        return [
            [['field', 'label', 'type'], 'required'],
            [['field', 'label'], 'filter', 'filter' => 'trim'],
            ['options', 'default', ''],
            ['status', 'default', 'value' => ViewConfig::STATUS_PRIVATE],
            [
                'status',
                'in',
                'range' => [
                    ViewConfig::STATUS_INACTIVE,
                    ViewConfig::STATUS_DELETE,
                    ViewConfig::STATUS_PRIVATE,
                    ViewConfig::STATUS_ACTIVE
                ]
            ],
        ];
    }

    public function getAll($condition = [])
    {
        $model = new ViewConfig();
        $list = $model->getAll($condition);

        $systemCondition = ['partner_id' => 0];
        if (isset($condition['user_id'])) {
            $systemCondition['status'] = ViewConfig::STATUS_ACTIVE;
        }
        $systemList = $model->assignDb(
            'db',
            function ($model) use ($systemCondition) {
                return $model->getAll($systemCondition);
            }
        );

        $sysViewArr = array_column($list, 'sys_view_id');
        foreach ($systemList as $item) {
            if (!in_array($item['sys_view_id'], $sysViewArr)) {
                $item['sys_view_id'] = $item['id'];
                array_unshift($list, $item);
            }
        }

        return $list;
    }

    public function getActiveView($viewId,$userId)
    {
        $conditon = [
            'id' => $viewId,
            'user_id' => $userId,
            'in' => ['status' => ViewConfig::STATUS_ACTIVE,ViewConfig::STATUS_PRIVATE]
        ];
        $list = $this->getAll($conditon);
        if(empty($list)) {
            return false;
        }

        return $list[0];
    }
}