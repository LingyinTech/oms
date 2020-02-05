<?php


namespace lingyin\traits\db;

/**
 * Trait ActiveRecordTrait
 * @package lingyin\traits\db
 */
trait ActiveRecordTrait
{

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
     * 设置查询条件
     *
     * @param array $params
     * @return \yii\db\ActiveQuery
     */
    protected function setWhere($params = [])
    {
        $obj = self::find();

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
                    foreach ($value as $k => $v) {
                        $obj->join($key, $k, $v);
                    }
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

}