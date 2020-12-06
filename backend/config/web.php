<?php

$params = require __DIR__ . '/params.php';

$env = require __DIR__ . "/../../common/config/env.php";

$params['db.env'] = $env;

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
        'class' => \lingyin\admin\components\AccessControl::class,
        'allowActions' => [
            'user/login',
            'user/register',
            'user/logout',
            'site/error',
        ],
    ],
    'modules' => [
        'admin' => [
            'class' => 'lingyin\admin\Module',
        ],
    ],
    'components' => [
        'request' => [
            'cookieValidationKey' => 'OQU4_eWEuJ2HnvLfgRgNXS8I4FtVOKLo',
        ],
        'cache' => [
            'class' => \lingyin\predis\Cache::class,
            'keyPrefix' => $env['redis_prefix'],
            'redis' => [
                'parameters' => [
                    'host' => $env['redis_host'],
                    'port' => 6379,
                ],

            ]
        ],
        'user' => [
            'identityClass' => \lingyin\admin\models\User::class,
            'enableAutoLogin' => true,
            'loginUrl' => ['user/login'],
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
            'dsn' => "mysql:host={$env['host']};dbname={$env['db']}",
            'username' => $env['user'],
            'password' => $env['pass'],
            'enableSchemaCache' => YII_ENV !== 'dev',
            'schemaCacheDuration' => 60,
            'schemaCache' => 'cache',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '<module:(admin)>/<controller:[\w-]+>/<action:[\w-]+><nouse:(.*)>' => '<module>/<controller>/<action>',
                '<controller:[\w-]+>/<action:[\w-]+><nouse:(.*)>' => '<controller>/<action>',
                '<controller:[\w-]+><nouse:(.*)>' => '<controller>/index',
            ],
        ],
    ],
    'params' => $params,
];

if (file_exists($file = __DIR__ . '/' . YII_ENV . '/web.php')) {
    $config = yii\helpers\ArrayHelper::merge($config, require($file));
}

return $config;
