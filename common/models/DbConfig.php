<?php


namespace lingyin\common\models;


use yii\behaviors\TimestampBehavior;
use yii\data\Pagination;
use yii\db\ActiveRecord;
use yii\db\Connection;
use yii\helpers\ArrayHelper;

/**
 * Class DbConfig
 * @package lingyin\common\models
 * @property $id
 * @property $partner_id
 * @property $environment
 * @property $config_name
 * @property $dsn
 * @property $login
 * @property $password
 * @property $status
 * @property $extra_config
 *
 */
class DbConfig extends ActiveRecord
{
    const STATUS_INACTIVE = 0;
    const STATUS_DELETE = 1;
    const STATUS_ACTIVE = 10;

    public static $dbMap = [];

    public function rules()
    {
        return [
            ['id', 'filter', 'filter' => 'intval', 'skipOnEmpty' => true],
            [['environment', 'config_name', 'dsn', 'login', 'password'], 'required'],
            ['status', 'default', 'value' => self::STATUS_INACTIVE],
            ['status', 'in', 'range' => [self::STATUS_INACTIVE, self::STATUS_DELETE, self::STATUS_ACTIVE]],
        ];
    }

    public function behaviors()
    {
        return [
            'TimestampBehavior' => TimestampBehavior::class,
        ];
    }

    public function getDbConfigById($partnerId)
    {
        if (!empty(app()->params['db.partner.config'][$partnerId])) {
            return app()->params['db.partner.config'][$partnerId];
        }

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

    public function getList()
    {
        $data = self::find();

        $page = app()->getRequest()->get('page', 1);
        $pageSize = app()->getRequest()->get('page_size', 20);
        $pages = new Pagination(
            [
                'totalCount' => $data->count(),
                'pageSizeParam' => 'page_size',
                'pageSize' => $pageSize,
            ]
        );

        $data->limit($pageSize);
        $data->offset(($page - 1) * $pageSize);

        return [
            'list' => $data->asArray()->all(),
            'pages' => $pages,
        ];
    }

    public function beforeSave($insert)
    {
        $this->extra_config = $this->extra_config ?? '';
        is_array($this->extra_config) && $this->extra_config = json_encode($this->extra_config);
        return parent::beforeSave($insert);
    }

    public function filterInputAttributes() {
        return [
            'partner_id',
            'environment',
            'config_name',
            'dsn',
            'login',
            'password',
            'status',
            'extra_config'
        ];
    }

}