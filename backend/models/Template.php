<?php


namespace backend\models;


use backend\base\ActiveRecord;

class Template extends ActiveRecord
{

    const STATUS_INACTIVE = 0;
    const STATUS_DELETE = 1;
    const STATUS_ACTIVE = 10;

    protected static $dbName = 'db';

}