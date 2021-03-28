<?php


namespace backend\base;


use lingyin\common\behaviors\SnowflakeBehavior;
use lingyin\traits\db\ActiveRecordTrait;
use lingyin\traits\db\ChooseConnectionTrait;
use yii\base\InvalidConfigException;
use yii\behaviors\TimestampBehavior;

class ActiveRecord extends \yii\db\ActiveRecord
{

    protected $snowflakePrimaryKey = true;

    use ActiveRecordTrait;

    use ChooseConnectionTrait;

    /**
     * @return array
     * @throws InvalidConfigException
     */
    public function behaviors()
    {
        $behaviors = [
            'TimestampBehavior' => TimestampBehavior::class,
        ];

        $schema = static::getTableSchema();
        if ($this->snowflakePrimaryKey && $primaryKey = $this->shouldSnowflakeId($schema)) {
            $behaviors['SnowflakeBehavior'] = [
                'class' => SnowflakeBehavior::class,
                'cachePrefix' => static::tableName(),
                'primaryAttribute' => $primaryKey,
            ];
        }
        return $behaviors;
    }

    protected function shouldSnowflakeId($schema)
    {
        $key = $schema->primaryKey;
        if (1 !== count($key)) {
            return false;
        }
        $primaryKey = $schema->columns[$key[0]];
        return $primaryKey->autoIncrement ? false : $key[0];
    }
}