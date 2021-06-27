<?php

use lingyin\admin\models\User;
use lingyin\admin\models\UserInfo;

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
        'user' => [
            'identityClass' => User::class,
            'enableAutoLogin' => true,
            'loginUrl' => ['user/login'],
            'on afterLogin' => function ($event) {
                if (empty(CURRENT_COMPANY_ID) || CURRENT_COMPANY_ID == $event->identity->current_partner_id) {
                    return;
                }

                UserInfo::$shouldCheckPartner = false;
                $userInfo = UserInfo::findOne(
                    [
                        'user_id' => $event->identity->getId(),
                        'partner_id' => CURRENT_COMPANY_ID,
                    ]
                );
                if (!empty($userInfo)) {
                    $event->identity->current_partner_id = CURRENT_COMPANY_ID;
                    $event->identity->saveData(
                        [
                            'id' => $event->identity->getId(),
                            'current_partner_id' => CURRENT_COMPANY_ID,
                        ]
                    );
                }
            },
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
        'accessCheck' => [
            'class' => \lingyin\admin\components\AccessCheck::class,
        ],
        'viewConfig' => [
            'class' => \backend\logic\ViewLogic::class,
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '<module:(admin|api)>/<controller:[\w-]+>/<action:[\w-]+><nouse:(.*)>' => '<module>/<controller>/<action>',
                '<controller:(order)>/<action:[\w-]+>/<viewId:([\d]+)>' => '<controller>/<action>',
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
