<?php


namespace lingyin\common\models;


use yii\db\ActiveRecord;
use yii\db\Connection;
use yii\helpers\ArrayHelper;

/**
 * Class DbConfig
 * @package lingyin\common\models
 * @property $extra_config
 */
class DbConfig extends ActiveRecord
{
    const STATUS_INACTIVE = 0;
    const STATUS_DELETE = 1;
    const STATUS_ACTIVE = 10;

    public static $dbName = 'db';

    public static $dbMap = [];

    public function getDbConfigById($partnerId)
    {
        if (isset(self::$dbMap[$partnerId])) {
            return self::$dbMap[$partnerId];
        }

        $this->getAll(['partner_id' => $partnerId]);
        return self::$dbMap[$partnerId] ?? false;
    }

    public function getAll($condition = [])
    {
        $condition['environment'] = YII_ENV;
        if (!isset($condition['status'])) {
            $condition['status'] = self::STATUS_ACTIVE;
        }
        $list = self::findAll($condition);
        if (!empty($list)) {
            foreach ($list as $config) {
                $value = [
                    'db_name' => $config['config_name'],
                    'connection' => [
                        'class' => $config['class'] ?: Connection::class,
                        'dsn' => $config['dsn'],
                        'username' => $config['login'],
                        'password' => $config['password'],
                    ]
                ];

                if (!empty($config['extra_config'])) {
                    $extra_config = json_decode($config['extra_config'], true);
                    if (is_array($extra_config)) {
                        $value['connection'] = ArrayHelper::merge(
                            $value['connection'],
                            $extra_config
                        );
                    }
                }

                if (!empty($config['slave_config']) && !empty($config['slaves'])) {
                    $value['connection']['slaveConfig'] = json_decode($config['slave_config'], true);
                    $value['connection']['slaves'] = json_decode($config['slaves'], true);
                }
                self::$dbMap[$config['partner_id']] = $value;
            }
        }

        return self::$dbMap;
    }

    public function beforeSave($insert)
    {
        $this->extra_config = $this->extra_config ?? '';
        return parent::beforeSave($insert);
    }

}