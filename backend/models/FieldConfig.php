<?php


namespace backend\models;


use backend\base\ActiveRecord;

class FieldConfig extends ActiveRecord
{
    const STATUS_INACTIVE = 0;
    const STATUS_DELETE = 1;
    const STATUS_ACTIVE = 10;

    const FIELD_TYPE = [
            'input' => '单行文本',
            'textarea' => '多行文本',
            'rich' => '富文本',
            'select' => '单选下拉框',
        ];

    public function getFieldType()
    {

    }
}