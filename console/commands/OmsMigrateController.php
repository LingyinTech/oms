<?php

namespace app\commands;


use lingyin\common\models\DbConfig;
use yii\console\ExitCode;
use yii\helpers\Console;

class OmsMigrateController extends \yii\console\controllers\MigrateController
{

    public $currentDbName = 'db';

    public $templateFile = '@console/views/migration.php';

    public $generatorTemplateFiles = [
        'create_table' => '@console/views/createTableMigration.php',
        'drop_table' => '@console/views/dropTableMigration.php',
        'add_column' => '@console/views/addColumnMigration.php',
        'drop_column' => '@console/views/dropColumnMigration.php',
        'create_junction' => '@console/views/createTableMigration.php',
    ];

    public function actionUp($limit = 0)
    {
        // 先更新公共库
        parent::actionUp($limit);

        $dbList = (new DbConfig())->getAll();
        $components = [];
        foreach ($dbList as $config) {
            $components[$config['db_name']] = $config['connection'];
        }
        app()->setComponents($components);

        foreach ($components as $db => $connect) {
            if ('db' === $db) {
                continue;
            }
            $this->currentDbName = $db;
            $this->db = app()->{$db};
            $this->stdout("*** 更新分库 {$db} ***\n", Console::FG_YELLOW);
            parent::actionUp($limit);
        }
    }

    public function confirm($message, $default = false)
    {
        $confirm = parent::confirm($message, $default);
        if ($confirm) {
            // 只保留一次交互
            $this->interactive = false;
        }
        return $confirm;
    }

    /**
     * @param string $class
     * @return \yii\db\Migration | \console\base\Migration
     */
    protected function createMigration($class)
    {
        return parent::createMigration($class);
    }

    protected function migrateUp($class)
    {
        if ($class === self::BASE_MIGRATION) {
            return true;
        }

        $this->stdout("*** applying $class\n", Console::FG_YELLOW);
        $start = microtime(true);
        $migration = $this->createMigration($class);

        $up = false;
        if (!empty($migration->dbAllowList) && !in_array($this->currentDbName, $migration->dbAllowList)) {
            $up = true;
            $this->stdout("*** 不在需要变更的 db 范围，直接跳过 $class \n\n", Console::FG_GREEN);
        }

        if (!$up && !empty($migration->dbExcludeList) && in_array($this->currentDbName, $migration->dbExcludeList)) {
            $up = true;
            $this->stdout("*** 在不需要变更的 db 范围，直接跳过 $class \n\n", Console::FG_GREEN);
        }

        if (!$up && false !== $migration->up()) {
            $up = true;
            $time = microtime(true) - $start;
            $this->stdout("*** applied $class (time: " . sprintf('%.3f', $time) . "s)\n\n", Console::FG_GREEN);
        }

        if ($up) {
            $this->addMigrationHistory($class);
            return true;
        }

        $time = microtime(true) - $start;
        $this->stdout("*** failed to apply $class (time: " . sprintf('%.3f', $time) . "s)\n\n", Console::FG_RED);

        return false;
    }
}