<?php


namespace app\commands;


use \PDO;
use yii\console\Controller;
use yii\helpers\Console;

class SystemController extends Controller
{
    /**
     * 创建公共库
     */
    public function actionInitDb()
    {
        if (!isset(app()->params['db.env'])) {
            $this->stdout("*** 数据库边接配置不存在，直接跳过\n", Console::FG_YELLOW);
            return;
        }

        $env = app()->params['db.env'];

        try {
            $conn = new PDO("mysql:host={$env['host']}", $env['user'], $env['pass']);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "CREATE DATABASE IF NOT EXISTS {$env['db']} DEFAULT CHARACTER SET utf8mb4 DEFAULT COLLATE utf8mb4_general_ci";
            $conn->exec($sql);
            $this->stdout("*** 数据库 {$env['db']} 创建成功\n\n", Console::FG_GREEN);
        } catch (\Exception $e) {
            $this->stdout("*** 数据库 {$env['db']} 创建失败\n\n", Console::FG_GREEN);
        }
    }

    public function actionInitNode()
    {
        $list = [
            ''
        ];

        foreach ($list as $sql) {
            app()->db->createCommand($sql)->execute();
        }
    }
}