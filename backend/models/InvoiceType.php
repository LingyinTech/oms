<?php


namespace backend\models;


use backend\base\ActiveRecord;
use lingyin\admin\models\Role;

class InvoiceType extends ActiveRecord
{

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 10;


    public function rules()
    {
        return [
            ['id', 'filter', 'filter' => 'intval', 'skipOnEmpty' => true],
            ['code','unique'],
            [['code','name'], 'filter', 'filter' => 'trim'],
            ['name', 'required'],
            ['status', 'default', 'value' => self::STATUS_INACTIVE],
            ['status', 'in', 'range' => [self::STATUS_INACTIVE, self::STATUS_ACTIVE]],
        ];
    }

    public function getCache()
    {
        $data = app()->cache->get('admin:invoice:type');
        if (empty($data)) {
            $list = $this->setWhere(['status' => self::STATUS_ACTIVE])->select('code,name')->asArray()->all();
            $data = [];
            foreach ($list as $item) {
                $data[$item['code']] = $item['name'];
            }

            app()->cache->set('admin:invoice:type',$data);
        }
        return $data;
    }

    public function deleteCache()
    {
        return app()->cache->delete('admin:invoice:type');
    }
}