<?php


namespace backend\base;


use lingyin\common\behaviors\SnowflakeBehavior;
use lingyin\traits\db\ActiveRecordTrait;
use lingyin\traits\db\ChooseConnectionTrait;
use yii\base\InvalidConfigException;
use yii\behaviors\TimestampBehavior;

class ActiveRecord extends \yii\db\ActiveRecord
{

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

        $schema = self::getTableSchema()->columns;
        if (isset($schema['partner_id'])) {
            $behaviors['SnowflakeBehavior'] = [
                'class' => SnowflakeBehavior::class,
                'cachePrefix' => self::tableName(),
            ];
        }

        return $behaviors;
    }
}