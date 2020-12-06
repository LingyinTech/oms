<?php


namespace console\base;


class Migration extends \yii\db\Migration
{

    public $dbAllowList = [];

    public $dbExcludeList = [];

    /**
     * @var bool 是否 DDL 操作
     */
    protected $ddlStatement = true;

    /**
     * 8.0 以上的版本 DDL 语句使用事务会报错
     * @return bool|null
     */
    public function up()
    {
        if ($this->ddlStatement !== true || version_compare(PHP_VERSION, '8.0.0') < 0) {
            return parent::up();
        }
        try {
            if ($this->safeUp() === false) {
                return false;
            }
        } catch (\Exception $e) {
            $this->printException($e);
            return false;
        } catch (\Throwable $e) {
            $this->printException($e);
            return false;
        }
        return null;
    }

    /**
     * @param \Throwable|\Exception $e
     */
    protected function printException($e)
    {
        echo 'Exception: ' . $e->getMessage() . ' (' . $e->getFile() . ':' . $e->getLine() . ")\n";
        echo $e->getTraceAsString() . "\n";
    }
}