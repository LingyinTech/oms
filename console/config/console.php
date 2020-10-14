<?php

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
        ],
    ],
];

if (file_exists($file = __DIR__ . '/' . YII_ENV . '/console.php')) {
    $config = yii\helpers\ArrayHelper::merge($config, require($file));
}

return $config;