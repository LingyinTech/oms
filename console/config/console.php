<?php
$params = [];

$env = require __DIR__ . "/../../common/config/env.php";

$params['db.env'] = $env;

$config = [
    'id' => 'oms-console',
    'name' => '订单管理系统-脚本',
    'basePath' => dirname(__DIR__),
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'bootstrap' => ['log'],
    'controllerNamespace' => 'app\commands',
    'components' => [
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => "mysql:host={$env['host']};dbname={$env['db']}",
            'username' => $env['user'],
            'password' => $env['pass'],
        ],
    ],
    'params' => $params,
];

if (file_exists($file = __DIR__ . '/' . YII_ENV . '/console.php')) {
    $config = yii\helpers\ArrayHelper::merge($config, require($file));
}

return $config;