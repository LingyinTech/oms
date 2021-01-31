<?php


namespace backend\models\vo;


use backend\base\Model;
use backend\models\ViewConfig;
use lingyin\admin\logic\PartnerLogic;

class ViewConfigForm extends Model
{
    public $id;
    public $partner_id;
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
            ['options', 'filterCheckInput']
        ];
    }

    public function filterNode($attribute, $params)
    {
        if ($this->options && is_array($this->options)) {
            return $this->options = implode('|', $this->options);
        }
    }

    public function saveField()
    {
        if ($this->validate()) {
            $model = new ViewConfig();
            $data = [];
            foreach ($model->filterInputAttributes() as $attribute) {
                if (isset($this->{$attribute})) {
                    $data[$attribute] = $this->{$attribute};
                }
            }
            $data['partner_id'] = PartnerLogic::filterPartnerId($this->partner_id);
            if ($model->saveData($data)) {
                return true;
            }
            $this->addErrors($model->getErrors());
        }

        return false;
    }

    public function getAll()
    {
        $model = new ViewConfig();
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