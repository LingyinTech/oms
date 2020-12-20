<?php


namespace lingyin\common\models\vo;

use lingyin\common\base\Model;
use lingyin\common\models\DbConfig;

class DbConfigForm extends Model
{

    public $id;
    public $partner_id;
    public $environment;
    public $config_name;
    public $dsn;
    public $login;
    public $password;
    public $status;
    public $extra_config;

    /**
     * 从模板中创建 db 配置
     * @param array $data
     * @param int $templateId
     * @return bool
     */
    public function createDbConfigByTemplate(array $data, $templateId = 0)
    {
        $dbConfig = DbConfig::findOne($templateId);
        $model = new DbConfig();
        foreach ($model->filterInputAttributes() as $attribute) {
            if (!isset($data[$attribute]) && isset($dbConfig->{$attribute})) {
                $data[$attribute] = $dbConfig->{$attribute};
            }
        }
        $model->isNewRecord = true;
        $model->setAttributes($data, false);
        return $model->save();
    }


}