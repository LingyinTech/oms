<?php


namespace backend\base;


use lingyin\traits\db\ActiveRecordTrait;

class ActiveRecord extends \yii\db\ActiveRecord
{

    use ActiveRecordTrait;

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