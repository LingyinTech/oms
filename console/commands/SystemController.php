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
            "INSERT IGNORE INTO `node` VALUES ('1', '0', '功能管理', '#', '', '', '99', '10', '1603103247', '1603103247')",
            "INSERT IGNORE INTO `node` VALUES ('2', '1', '菜单列表', '/admin/node/index', '', '', '99', '10', '1603103281', '1603103315')",
            "INSERT IGNORE INTO `node` VALUES ('3', '1', '添加菜单', '/admin/node/add', '', '', '99', '10', '1603103371', '1603103371')",
            "INSERT IGNORE INTO `node` VALUES ('4', '1', '租户管理', '/admin/partner/index', '', '', '99', '10', '1603103520', '1603103520')",
            "INSERT IGNORE INTO `node` VALUES ('5', '4', '保存租户', '/admin/partner/save', '', '', '99', '2', '1603103713', '1603103740')",
            "INSERT IGNORE INTO `node` VALUES ('6', '0', '权限管理', '#', '', '', '90', '10', '1603103798', '1603103798')",
            "INSERT IGNORE INTO `node` VALUES ('7', '6', '权限组管理', '/admin/role/index', '', '', '1', '10', '1603103888', '1603103888')",
            "INSERT IGNORE INTO `node` VALUES ('8', '7', '保存权限组', '/admin/role/save', '', '', '99', '2', '1603103931', '1603103931')",
            "INSERT IGNORE INTO `node` VALUES ('9', '6', '权限设置', '/admin/role/node', '', '', '10', '10', '1603103971', '1603103971')",
            "INSERT IGNORE INTO `node` VALUES ('10', '9', '保存权限设置', '/admin/role/save-node', '', '', '99', '2', '1603104082', '1603104082')",
            "INSERT IGNORE INTO `node` VALUES ('11', '6', '权限分配', '/admin/role/user', '', '', '20', '10', '1603104132', '1603104132')",
            "INSERT IGNORE INTO `node` VALUES ('12', '11', '权限分配保存', '/admin/role/save-user', '', '', '99', '2', '1603104181', '1603104181')",

        ];

        foreach ($list as $sql) {
            app()->db->createCommand($sql)->execute();
        }

        $this->stdout("*** 菜单初始化成功\n\n", Console::FG_GREEN);
    }
}