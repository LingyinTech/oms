<?php

namespace lingyin\traits\db;

use lingyin\common\models\DbConfig;
use Yii;
use yii\db\Connection;

/**
 * Trait ActiveRecordTrait
 * @package lingyin\traits\db
 */
trait ChooseConnectionTrait
{
    public static $dbName = null;

    public static $dbInstance = null;

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

        try {
            if (app()->user->getIdentity()) {
                $partnerId = app()->user->getIdentity()->partner_id;

                $config = (new DbConfig())->getDbConfigById($partnerId);

                return self::$dbInstance = new Connection($config['connection']);
            }
        } catch (\Throwable $e) {
        }

        return self::$dbInstance = app()->db;
    }

    /**
     * @return Connection
     */
    public static function getDb()
    {
        self::chooseDb();

        return self::$dbInstance;
    }

}