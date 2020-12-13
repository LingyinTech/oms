<?php

namespace lingyin\traits\db;

use lingyin\common\models\DbConfig;
use yii\base\InvalidConfigException;
use yii\db\Connection;

/**
 * Trait ActiveRecordTrait
 * @package lingyin\traits\db
 */
trait ChooseConnectionTrait
{
    public static $dbName = null;

    public static $dbInstance = null;

    /**
     * @return mixed|object|Connection|null
     * @throws \Throwable
     * @throws InvalidConfigException
     */
    public static function chooseDb()
    {
        if (null !== self::$dbName) {
            return self::$dbInstance = app()->{self::$dbName};
        }

        $allocate = app()->params['db.allocate'];
        $table = self::tableName();
        if (isset($allocate[$table])) {
            return self::$dbInstance = app()->{$allocate[$table]};
        }

        self::$dbName = 'db';
        $schema = self::getTableSchema()->columns;
        self::$dbName = null;
        if (isset($schema['partner_id']) && app()->user->getIdentity()) {
            $partnerId = app()->user->getIdentity()->current_partner_id;
            if ($config = (new DbConfig())->getDbConfigById($partnerId)) {
                $configName = $config['db_name'];
                if ($instance = app()->get($configName, false)) {
                    return self::$dbInstance = $instance;
                }
                $connection = $config['connection'];
                app()->setComponents([$configName => $connection]);
                return self::$dbInstance = app()->{$configName};
            }
        }

        // 表里没有 partner_id 字段，直接走默认db
        return self::$dbInstance = app()->db;
    }

    /**
     * @return Connection
     * @throws \Throwable
     * @throws InvalidConfigException
     */
    public static function getDb()
    {
        self::chooseDb();

        return self::$dbInstance;
    }

}