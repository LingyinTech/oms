<?php


namespace backend\models\vo;


use backend\base\Model;
use backend\models\FieldConfig;
use lingyin\admin\logic\PartnerLogic;

class FieldConfigForm extends Model
{
    public $id;
    public $partner_id;
    public $field;
    public $label;
    public $type;
    public $options;
    public $status;
    public $remark;

    public function rules()
    {
        return [
            ['id', 'filter', 'filter' => 'intval', 'skipOnEmpty' => true],
            [['field', 'label', 'type'], 'required'],
            [['field', 'label'], 'filter', 'filter' => 'trim'],
            ['status', 'default', 'value' => FieldConfig::STATUS_INACTIVE],
            [
                'status',
                'in',
                'range' => [
                    FieldConfig::STATUS_INACTIVE,
                    FieldConfig::STATUS_DELETE,
                    FieldConfig::STATUS_ACTIVE
                ]
            ],
            ['options', 'filterCheckInput']
        ];
    }

    public function filterCheckInput($attribute, $params)
    {
        if ($this->options && is_array($this->options)) {
            return $this->options = implode('|', $this->options);
        }
    }

    public function initData($id)
    {
        if ($model = FieldConfig::findOne($id)) {
            $this->attributes = $model->attributes;
        }
    }

    public function saveField()
    {
        if ($this->validate()) {
            $model = new FieldConfig();
            $data = [];
            foreach ($model->filterInputAttributes() as $attribute) {
                if (isset($this->{$attribute})) {
                    $data[$attribute] = $this->{$attribute};
                }
            }
            $data['partner_id'] = PartnerLogic::filterPartnerId(
                $this->partner_id
            );
            if ($model->saveData($data)) {
                return true;
            }
            $this->addErrors($model->getErrors());
        }

        return false;
    }

    public function getAll()
    {
        $model = new FieldConfig();
        $list = $model->getAll([]);

        $systemList = $model->assignDb(
            'db',
            function ($model) {
                return $model->getAll(['partner_id' => 0]);
            }
        );

        $fieldArr = array_column($list, 'field');
        foreach ($systemList as $item) {
            if (!in_array($item['field'], $fieldArr)) {
                array_unshift($list, $item);
            }
        }

        return $list;
    }
}