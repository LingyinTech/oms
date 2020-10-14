<?php

namespace lingyin\traits\db;

use lingyin\admin\logic\PartnerLogic;
use yii\data\Pagination;
use yii\db\ActiveQuery;

/**
 * Trait ActiveRecordTrait
 * @package lingyin\traits\db
 */
trait ActiveRecordTrait
{

    public static $shouldCheckPartner = true;
    public static $shouldCheckPartnerSave = true;

    /**
     * 允许接收用户输入的字段
     *
     * @return array
     */
    public function filterInputAttributes()
    {
        return $this->attributes();
    }

    /**
     * 获取主键
     *
     * @return string | array
     */
    public static function getKey()
    {
        $keys = static::primaryKey();
        if (count($keys) == 1) {
            return $keys[0];
        }
        return $keys;
    }

    /**
     * 填加或更新数据
     *
     * @param array $data
     * @param bool $insert 是否直接添加
     * @return bool
     */
    public function saveData($data, $insert = false)
    {
        if (!$insert) {
            $primaryKey = static::getKey();

            if (is_string($primaryKey)) {
                !empty($data[$primaryKey]) && $model = self::findOne($data[$primaryKey]);
            } elseif (is_array($primaryKey)) {
                $condition = [];
                $hasKey = true;
                foreach ($primaryKey as $key) {
                    if (!isset($data[$key])) {
                        $hasKey = false;
                        break;
                    }
                    $condition[$key] = $data[$key];
                }
                $hasKey && $model = self::findOne($condition);
            }
        }

        if (empty($model)) {
            $this->isNewRecord = true;
            $this->setAttributes($data, false);
            $result = $this->save();
        } else {
            foreach ($data as $key => $val) {
                $model->{$key} = $val;
            }
            $result = $model->save();
        }

        if (method_exists($this, 'deleteCache')) {
            $this->deleteCache();
        }

        return $result;
    }

    /**
     * 列表分页查询
     * @param $params
     * @return array
     * @throws \Throwable
     */
    public function getList($params)
    {
        $data = $this->setWhere($params);

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
        isset($params['select']) && $data->select($params['select']);
        isset($params['orderBy']) && $data->orderBy($params['orderBy']);

        return [
            'list' => $data->asArray()->all(),
            'pages' => $pages,
        ];
    }

    /**
     * 查询所有记录
     * @param $params
     * @return array
     * @throws \Throwable
     */
    public function getAll($params)
    {
        $data = $this->setWhere($params);

        isset($params['select']) && $data->select($params['select']);
        isset($params['orderBy']) && $data->orderBy($params['orderBy']);

        return $data->asArray()->all();
    }

    /**
     * 设置查询条件
     *
     * @param array $params
     * @return ActiveQuery
     * @throws \Throwable
     */
    public function setWhere($params = [])
    {
        $obj = self::find();

        self::fixConditionWithPartner($params);

        foreach ($params as $key => $value) {
            switch ($key) {
                case 'page':
                case 'orderBy':
                case 'order by':
                case 'limit':
                case 'pageSize':
                case 'offset':
                case 'select':
                    // 这些不是条件，不处理
                    break;
                case 'alias':
                    $obj->alias($value);
                    break;
                case 'join':
                case 'left join':
                    // 不允许联表查询
                    break;
                case 'in':
                case '>':
                case '>=':
                case '<':
                case '<=':
                    foreach ($value as $k => $v) {
                        $obj->andWhere([$key, $k, $v]);
                    }
                    break;
                case 'like':
                    foreach ($value as $k => $v) {
                        if (is_string($v) && strpos($v, '%') !== false) {
                            $obj->andWhere([$key, $k, $v, false]);
                        } else {
                            $obj->andWhere([$key, $k, $v]);
                        }
                    }
                    break;
                default:
                    $tmpKey = $key;
                    if (strpos($key, ".") !== false) {
                        $tmpKey = substr(strrchr($key, '.'), 1);
                    }
                    $obj->andWhere("$key = :$tmpKey", [":$tmpKey" => $value]);
            }
        }

        return $obj;
    }

    /**
     * @param $condition
     * @return ActiveRecordTrait|null
     * @throws \Throwable
     */
    public static function findOne($condition)
    {
        self::fixConditionWithPartner($condition);
        return parent::findOne($condition);
    }

    public static function findAll($condition)
    {
        self::fixConditionWithPartner($condition);
        return parent::findAll($condition);
    }

    /**
     * @param bool $insert
     * @return bool
     * @throws \Throwable
     */
    public function beforeSave($insert)
    {
        if (static::$shouldCheckPartnerSave && !PartnerLogic::checkPartnerId($this->partner_id)) {
            $this->addError('msg', '非法操作');
            return false;
        }

        return parent::beforeSave($insert);
    }

    protected static function fixConditionWithPartner(&$condition)
    {
        if (!static::$shouldCheckPartner) {
            return;
        }

        $schema = self::getTableSchema()->columns;
        if (!isset($schema['partner_id'])) {
            return;
        }

        PartnerLogic::setPartnerId($condition);
    }

    /**
     * @param bool $shouldCheckPartner
     */
    public function setShouldCheckPartner($shouldCheckPartner)
    {
        self::$shouldCheckPartner = $shouldCheckPartner;
    }

    /**
     * @param bool $shouldCheckPartnerSave
     */
    public function setShouldCheckPartnerSave($shouldCheckPartnerSave)
    {
        self::$shouldCheckPartnerSave = $shouldCheckPartnerSave;
    }

}