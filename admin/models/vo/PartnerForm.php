<?php


namespace lingyin\admin\models\vo;


use lingyin\admin\models\Partner;
use lingyin\admin\base\Model;

class PartnerForm extends Model
{

    public $id;
    public $code;
    public $short_code;
    public $name;
    public $status;
    public $active_start;
    public $active_end;

    public function rules()
    {
        return [
            ['id', 'filter', 'filter' => 'intval', 'skipOnEmpty' => true],
            [['code', 'name'], 'filter', 'filter' => 'trim'],
            [['code', 'name'], 'required'],
            [
                ['code', 'short_code'],
                'unique',
                'targetClass' => Partner::class,
                'filter' => function ($query) {
                    $query->andWhere(['not', ['id' => $this->id]]);
                },
            ],
            ['status', 'default', 'value' => Partner::STATUS_INACTIVE],
            [
                'status',
                'in',
                'range' => [
                    Partner::STATUS_INACTIVE,
                    Partner::STATUS_DELETE,
                    Partner::STATUS_LIMITED,
                    Partner::STATUS_ACTIVE,
                ],
            ],
            [
                ['active_start', 'active_end'],
                'filter',
                'filter' => 'strtotime',
                'skipOnEmpty' => true,
            ],
        ];
    }

    public function savePartner()
    {
        if ($this->validate()) {
            $model = new Partner();
            $data = [
                'code' => $this->code,
                'short_code' => $this->short_code,
                'name' => $this->name,
                'status' => $this->status,
            ];
            !empty($this->id) && $data['id'] = $this->id;
            !empty($this->active_start) && $data['active_start'] = $this->active_start;
            !empty($this->active_end) && $data['active_end'] = $this->active_end;

            return $model->saveData($data);
        }

        return false;
    }

    public function getPartnerList()
    {
        $all = (new Partner())->getAll([]);

        $list = [];
        foreach ($all as $item) {
            $list[$item['id']] = $item['name'];
        }

        return $list;
    }
}