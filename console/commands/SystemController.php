<?php


namespace app\commands;


use lingyin\common\models\DbConfig;
use PDO;
use Yii;
use yii\console\Controller;
use yii\helpers\ArrayHelper;
use yii\helpers\Console;

class SystemController extends Controller
{

    /*public function options($actionID)
    {
        $options = [
            'db'
        ];
        return ArrayHelper::merge(parent::options($actionID), $options);
    }*/

    /**
     * 创建新库
     * 目前所有数据库共用一个账号和密码，后续再考虑独立
     * @param string $db
     */
    public function actionInitDb($db = 'db')
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
            $dbExist = false;
            foreach ($res as $k => $v) {
                if ($v['Database'] === $db) {
                    $this->stdout("*** 数据库 {$db} 已存在\n\n", Console::FG_GREEN);
                    $dbExist = true;
                    break;
                }
            }

            if (!$dbExist) {
                $sql = "CREATE DATABASE IF NOT EXISTS {$db} DEFAULT CHARACTER SET utf8mb4 DEFAULT COLLATE utf8mb4_general_ci";
                $conn->exec($sql);
                $this->stdout("*** 数据库 {$db} 创建成功\n\n", Console::FG_GREEN);
            }

            if ('root' !== $env['user']) {
                $sql = "GRANT ALL ON `{$db}`.* TO '{$env['user']}'@'%' IDENTIFIED BY '{$env['pass']}';flush privileges;";
                $conn->exec($sql);
                $this->stdout("*** 用户权限更新成功\n\n", Console::FG_GREEN);
            }

            if ('db' !== $db) {
                $dbList = (new DbConfig())->getAll(['config_name' => $db]);
                $components = [];
                foreach ($dbList as $config) {
                    $components[$config['db_name']] = $config['connection'];
                }
                app()->setComponents($components);
            }

            app()->runAction('oms-migrate/up', ['db' => $db, 'interactive' => false]);
        } catch (\Exception $e) {
            $this->stdout("*** 数据库 {$db} 创建失败，{$e->getMessage()}\n\n", Console::FG_RED);
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
            "INSERT IGNORE INTO `node` VALUES ('13', '0', '系统管理', '#', '', '', '99', '10', '1608195146', '1608195146')",
            "INSERT IGNORE INTO `node` VALUES ('14', '13', '数据库配置', '/admin/system/db-config', '', '', '10', '10', '1608195441', '1608195441')",
            "INSERT IGNORE INTO `node` VALUES ('15', '0', '公司信息管理', '#', '', '', '80', '10', '1610976029', '1610976029')",
            "INSERT IGNORE INTO `node` VALUES ('16', '15', '员工管理', '/admin/user/index', '', '', '10', '10', '1610976121', '1610976121')",
            "INSERT IGNORE INTO `node` VALUES ('17', '16', '添加员工', '/admin/user/add', '', '', '10', '3', '1610976225', '1610976225')",
            "INSERT IGNORE INTO `node` VALUES ('18', '16', '批量导入', '/admin/user/batch-add', '', '', '20', '3', '1610976268', '1610976268')",
            "INSERT IGNORE INTO `node` VALUES ('19', '15', '组织图', '/admin/department/index', '', '', '9', '10', '1610978169', '1610978169')",
            "INSERT IGNORE INTO `node` VALUES ('20', '19', '添加部门', '/admin/department/save', '', '', '10', '2', '1610978242', '1610978283')",
            "INSERT IGNORE INTO `node` VALUES ('21', '0', '应用设置', '#', '', '', '95', '10', '1611059524', '1611059524')",
            "INSERT IGNORE INTO `node` VALUES ('22', '21', '自定义字段', '/field-setting/index', '', '', '95', '10', '1611059595', '1611059595')",
            "INSERT IGNORE INTO `node` VALUES ('23', '21', '页面模板', '/template/index', '', '', '90', '10', '1611059705', '1611059705')",
            "INSERT IGNORE INTO `node` VALUES ('24', '21', '订单类别', '/workitem-type/index', '', '', '20', '10', '1611059759', '1611059759')",
            "INSERT IGNORE INTO `node` VALUES ('25', '21', '订单流程', '/workflow/index', '', '', '50', '10', '1611059838', '1611059838')",
        ];

        foreach ($list as $sql) {
            app()->db->createCommand($sql)->execute();
        }

        $this->stdout("*** 菜单初始化成功\n\n", Console::FG_GREEN);
    }

    public function actionDumpDbConfig()
    {
        $config_file = Yii::getAlias('@common') . '/config/db_partner_config.php';
        $handle = fopen($config_file, 'w');
        if (flock($handle, LOCK_EX)) {
            $config = (new DbConfig())->getAll();
            $config = !empty($config) ? var_export($config, true) : '[]';
            fwrite($handle, '<?php' . PHP_EOL . PHP_EOL . 'return ' . $config . ';');
            flock($handle, LOCK_UN);
            $this->stdout("*** 配置文件生成成功 K.\n", Console::FG_GREEN);
        } else {
            $this->stdout("*** 配置文件生成失败 K.\n", Console::FG_RED);
        }
        fclose($handle);
    }
}