<?php


namespace lingyin\admin\base;


use lingyin\traits\db\ActiveRecordTrait;
use lingyin\traits\db\ChooseConnectionTrait;

class ActiveRecord extends \yii\db\ActiveRecord
{
    use ActiveRecordTrait;

    use ChooseConnectionTrait;

    public function beforeSave($insert)
    {
        $nowTime = time();
        if ($insert) {
            $this->setAttributes([
                'created_at' => $nowTime,
                'updated_at' => $nowTime,
            ], false);
        } else {
            $this->setAttributes([
                'updated_at' => $nowTime,
            ], false);
        }

        return parent::beforeSave($insert);
    }

}