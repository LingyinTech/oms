<?php


namespace lingyin\admin\models\vo;

use lingyin\admin\logic\PartnerLogic;
use lingyin\admin\models\Department;
use lingyin\admin\models\Partner;
use yii\base\Model;

class DepartmentForm extends Model
{

    public $id;
    public $name;
    public $remark;
    public $sort;
    public $partner_id;

    public function rules()
    {
        return [
            ['id', 'filter', 'filter' => 'intval', 'skipOnEmpty' => true],
            ['sort','default','value' => 99],
            [['remark','name'], 'filter', 'filter' => 'trim'],
            ['name', 'required'],
        ];
    }

    /**
     * 创建部门
     * @return bool
     * @throws \Throwable
     */
    public function saveDepartment()
    {
        if ($this->validate()) {
            $model = new Department();
            $data = [];
            foreach ($model->filterInputAttributes() as $attribute) {
                if (isset($this->{$attribute})) {
                    $data[$attribute] = $this->{$attribute};
                }
            }
            $data['partner_id'] = PartnerLogic::filterPartnerId(false);
            return $model->saveData($data);
        }

        return false;
    }

    public function getDepartmentList()
    {
        $all = (new Department())->getAll([]);

        $list = [];
        foreach ($all as $item) {
            $list[$item['id']] = $item['name'];
        }

        return $list;
    }

}