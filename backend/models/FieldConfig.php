<?php


namespace backend\models;


use backend\base\ActiveRecord;

class FieldConfig extends ActiveRecord
{
    const STATUS_INACTIVE = 0;
    const STATUS_DELETE = 1;
    const STATUS_ACTIVE = 10;

}