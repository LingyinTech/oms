<?php

$params = require __DIR__ . '/params.php';

$config = [
    'id' => 'oms',
    'name' => '订单管理系统',
    'basePath' => dirname(__DIR__),
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'as access' => [
        'class' => \backend\components\admin\AccessControl::class,
        'allowActions' => [
            'user/login',
            'user/register',
            'site/error'
        ]
    ],
    'components' => [
        'request' => [
            'cookieValidationKey' => 'OQU4_eWEuJ2HnvLfgRgNXS8I4FtVOKLo',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
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
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
    ],
    'params' => $params,
];

if (is_file($file = __DIR__ . '/'.YII_ENV.'/web.php')) {
    $config = yii\helpers\ArrayHelper::merge($config, require($file));
}

return $config;
