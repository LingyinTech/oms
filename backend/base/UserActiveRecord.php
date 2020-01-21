<?php


namespace backend\base;


use yii\db\ActiveRecord;

class UserActiveRecord extends ActiveRecord
{


    public static function getDb()
    {
        return app()->userDb;
    }

}