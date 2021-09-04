<?php


namespace console\base;


class Migration extends \yii\db\Migration
{

    public $dbAllowList = [];

    public $dbExcludeList = [];

    // 是否通过验证，未通过生产环境不执行
    public $testStatus = true;

    public function checkStatus()
    {
        return $this->testStatus || 'dev' === YII_ENV;
    }

    /**
     * @param string $dbName
     * 黑白名单较验，优先白名单
     * @return bool
     */
    public function checkDbList($dbName)
    {
        if (!empty($this->dbAllowList) && !in_array($dbName, $this->dbAllowList)) {
            return false;
        }

        if (!empty($this->dbExcludeList) && in_array($dbName, $this->dbExcludeList)) {
            return false;
        }

        return true;
    }
}