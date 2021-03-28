<?php

namespace backend\models\vo;


use backend\base\Model;
use backend\models\WorkitemType;

class WorkitemTypeForm extends Model
{
    public $id;
    public $name;
    public $status;
    public $workflow_id;
    public $template_id;
    public $sort;

    public function rules()
    {
        return [
            [['name', 'sort'], 'required'],
            ['status', 'default', 'value' => WorkitemType::STATUS_INACTIVE],
            [
                'status',
                'in',
                'range' => [
                    WorkitemType::STATUS_INACTIVE,
                    WorkitemType::STATUS_DELETE,
                    WorkitemType::STATUS_ACTIVE
                ]
            ],
        ];
    }

    public function initData($id)
    {
        if ($model = WorkitemType::findOne($id)) {
            $this->attributes = $model->attributes;
        }
    }
}