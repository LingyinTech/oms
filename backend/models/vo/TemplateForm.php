<?php


namespace backend\models\vo;


use backend\base\Model;
use backend\models\Template;
use lingyin\admin\logic\PartnerLogic;

class TemplateForm extends Model
{
    public $id;
    public $partner_id;
    public $path; // 页面路径
    public $name;
    public $form_config;
    public $status;
    public $remark;

    public function rules()
    {
        return [
            ['id', 'filter', 'filter' => 'intval', 'skipOnEmpty' => true],
            [['name', 'path'], 'required'],
            [['name', 'path'], 'filter', 'filter' => 'trim'],
            ['status', 'default', 'value' => Template::STATUS_INACTIVE],
            [
                'status',
                'in',
                'range' => [
                    Template::STATUS_INACTIVE,
                    Template::STATUS_DELETE,
                    Template::STATUS_ACTIVE
                ]
            ],
        ];
    }

    public function initData($id)
    {
        $model = Template::findOne($id);
    }

    public function getTemplateByPath($path)
    {
        return [
            [
                'title' => '收货人信息',
                'columnList' => [
                    [
                        'type' => 'normal',
                        'fieldList' => [
                            ['label' => '收货人', 'field' => 'consignee_name',],
                            ['label' => '邮编', 'field' => 'consignee_zip',],
                            ['label' => '电话', 'field' => 'consignee_phone',],
                            ['label' => '座机', 'field' => 'consignee_tel',],
                        ]
                    ],
                    [
                        'type' => 'address',
                        'fieldList' => [
                            ['label' => '顾客地址', 'field' => 'consignee_region',],
                            [
                                'label' => '详细地址',
                                'field' => 'consignee_address',
                                'remark' => '请输入详细地址'
                            ]
                        ]
                    ],
                ]
            ]
        ];
    }

    public function getAll($condition = [])
    {
        $model = new Template();
        $list = $model->getAll($condition);

        $systemCondition = ['partner_id' => 0];
        $systemCondition['status'] = Template::STATUS_ACTIVE;
        $systemList = $model->assignDb(
            'db',
            function ($model) use ($systemCondition) {
                return $model->getAll($systemCondition);
            }
        );

        $sysViewArr = array_column($list, 'sys_template_id');
        foreach ($systemList as $item) {
            if (!in_array($item['sys_template_id'], $sysViewArr)) {
                $item['sys_template_id'] = $item['id'];
                array_unshift($list, $item);
            }
        }

        return $list;
    }

    public function saveTemplate()
    {
        if ($this->validate()) {
            $model = new Template();
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
}