<?php


namespace backend\models;


use backend\base\ActiveRecord;

class OrderType extends ActiveRecord
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;


    public function rules()
    {
        return [
            ['id', 'filter', 'filter' => 'intval', 'skipOnEmpty' => true],
            ['code', 'unique'],
            [['code', 'name'], 'filter', 'filter' => 'trim'],
            ['name', 'required'],
            ['status', 'default', 'value' => self::STATUS_INACTIVE],
            ['status', 'in', 'range' => [self::STATUS_INACTIVE, self::STATUS_ACTIVE]],
        ];
    }

    public function getCache()
    {
        $data = app()->cache->get('admin:order:type');
        if (empty($data)) {
            $list = $this->getList(['status' => self::STATUS_ACTIVE], 'code,name');
            $data = [];
            foreach ($list as $item) {
                $data[$item['code']] = $item['name'];
            }
            app()->cache->set('admin:order:type',$data);
        }
        return $data;
    }

    public function deleteCache()
    {
        return app()->cache->delete('admin:order:type');
    }

    /**
     * 查询列表
     *
     * @param array $params
     * @param array | string $fields
     * @return array | false
     */
    public function getList($params = [], $fields = '*')
    {
        return $this->setWhere($params)->select($fields)->asArray()->all();
    }
}