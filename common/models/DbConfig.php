<?php


namespace lingyin\common\models;


use yii\db\ActiveRecord;
use yii\db\Connection;

class DbConfig extends ActiveRecord
{
    public static $dbName = 'db';

    public static $dbMap = [];

    public function getDbConfigById($partnerId)
    {
        if (isset(self::$dbMap[$partnerId])) {
            return self::$dbMap[$partnerId];
        }

        $config = self::findOne(['partner_id' => $partnerId, 'environment' => YII_ENV]);
        if ($config) {
            return self::$dbMap[$config['partner_id']] = [
                'db_name' => $config['config_name'],
                'connection' => [
                    'class' => $config['class'] ?: Connection::class,
                    'dsn' => $config['dsn'],
                    'username' => $config['login'],
                    'password' => $config['password'],
                ]
            ];
        }
        return false;
    }

    public function getAll($env = YII_ENV)
    {
        $list = self::findAll(['environment' => $env]);
        if (!empty($list)) {
            foreach ($list as $config) {
                self::$dbMap[$config['partner_id']] = [
                    'db_name' => $config['config_name'],
                    'connection' => [
                        'class' => $config['class'] ?: Connection::class,
                        'dsn' => $config['dsn'],
                        'username' => $config['login'],
                        'password' => $config['password'],
                    ]
                ];
            }
        }

        return self::$dbMap;
    }

}