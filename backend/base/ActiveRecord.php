<?php


namespace backend\base;


use lingyin\traits\db\ActiveRecordTrait;
use lingyin\traits\db\ChooseConnectionTrait;
use yii\behaviors\TimestampBehavior;

class ActiveRecord extends \yii\db\ActiveRecord
{
    use ActiveRecordTrait;

    use ActiveRecordTrait;

    use ChooseConnectionTrait;

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }
}