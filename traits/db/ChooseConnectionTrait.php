<?php

namespace lingyin\traits\db;

use lingyin\common\models\DbConfig;
use yii\base\InvalidConfigException;
use yii\db\Connection;

/**
 * 数据库分为公共库和业务库，业务库按业务单元拆分，不同业务单元数据库独立，保证数据隔离
 * Trait ActiveRecordTrait
 * @package lingyin\traits\db
 */
trait ChooseConnectionTrait
{
    protected static $dbName = null;

    protected static $dbInstance = null;

    /**
     * @return mixed|object|Connection|null
     * @throws \Throwable
     * @throws InvalidConfigException
     */
    public static function getDb()
    {
        if (null !== static::$dbName) {
            return static::$dbInstance = app()->{static::$dbName};
        }

        $allocate = app()->params['db.allocate'];
        $table = static::tableName();
        if (isset($allocate[$table])) {
            return static::$dbInstance = app()->{$allocate[$table]};
        }

        static::$dbName = 'db';
        $schema = static::getTableSchema()->columns;
        static::$dbName = null;
        if (isset($schema['partner_id']) && app()->user->getIdentity()) {
            $partnerId = app()->user->getIdentity()->current_partner_id;
            if ($config = (new DbConfig())->getDbConfigById($partnerId)) {
                $configName = $config['db_name'];
                // 防此重复初始化
                if ($instance = app()->get($configName, false)) {
                    return self::$dbInstance = $instance;
                }
                $connection = $config['connection'];
                app()->setComponents([$configName => $connection]);
                return static::$dbInstance = app()->{$configName};
            }
        }

        // 表里没有 partner_id 字段，直接走默认db
        return static::$dbInstance = app()->db;
    }

    public function assignDb($db, callable $callback)
    {
        $old = static::$dbName;
        static::$dbName = $db;
        try {
            $result = call_user_func($callback, $this);
        } catch (\Exception $e) {
            throw $e;
        } catch (\Throwable $e) {
            throw $e;
        } finally {
            static::$dbName = $old;
        }

        return $result;
    }
}