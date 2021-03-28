<?php


namespace backend\models;


use backend\base\ActiveRecord;

class WorkitemType extends ActiveRecord
{
    const STATUS_INACTIVE = 0; // 未配置完成
    const STATUS_DELETE = 1;
    const STATUS_ACTIVE = 10;

}