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
            $conn = new PDO("mysql:host={$env['host']}", 'root', $env['root.pass']);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "show databases;";
            $res = $conn->query($sql);
            $res = $res->fetchAll(PDO::FETCH_ASSOC);
            foreach ($res as $k => $v) {
                if ($v['Database'] === $env['db']) {
                    $this->stdout("*** 数据库 {$env['db']} 已存在\n\n", Console::FG_GREEN);
                    return;
                }
            }

            $sql = "CREATE DATABASE IF NOT EXISTS {$env['db']} DEFAULT CHARACTER SET utf8mb4 DEFAULT COLLATE utf8mb4_general_ci";
            $conn->exec($sql);
            $this->stdout("*** 数据库 {$env['db']} 创建成功\n\n", Console::FG_GREEN);

            if ('root' !== $env['user']) {
                $sql = "CREATE USER '{$env['user']}'@'%' IDENTIFIED BY '{$env['pass']}'";
                $conn->exec($sql);
                $this->stdout("*** 创建用户 {$env['user']} 成功\n\n", Console::FG_GREEN);

                $sql = "GRANT ALL ON `{$env['db']}`.* TO '{$env['user']}'@'%';flush privileges;";
                $conn->exec($sql);
                $this->stdout("*** 权限更新成功\n\n", Console::FG_GREEN);
            }

            app()->runAction('oms-migrate/init-base');

        } catch (\Exception $e) {
            $this->stdout("*** 数据库 {$env['db']} 创建失败，{$e->getMessage()}\n\n", Console::FG_RED);
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