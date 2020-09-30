<?php

return [
    'bootstrap' => ['debug', 'gii'],
    'as access' => [
        'allowActions' => [
            'debug/*',
        ],
        'supperAdmin' => [
            'actors315'
        ]
    ],
    'components' => [
        'db' => [
            'dsn' => 'mysql:host=127.0.0.1;dbname=db_order_flow',
            'username' => 'sso_master',
            'password' => 'Twinkle2020',
        ],
        'authDb' => [
            'dsn' => 'mysql:host=127.0.0.1;dbname=db_twinkle_ucenter',
            'username' => 'sso_master',
            'password' => 'Twinkle2020',
        ],
        'cache' => [
            'keyPrefix' => 'oms:',
            'redis' => [
                'parameters' => [
                    'host' => 'dev.local.redis',
                    'port' => 6379,
                ]
            ]
        ],
    ],
    'modules' => [
        'debug' => [
            'class' => 'yii\debug\Module',
            // uncomment the following to add your IP if you are not connecting from localhost.
            'allowedIPs' => ['127.0.0.1', '::1', '172.17.0.1'],
        ],
        'gii' => [
            'class' => 'yii\gii\Module',
            // uncomment the following to add your IP if you are not connecting from localhost.
            'allowedIPs' => ['127.0.0.1', '::1', '172.17.0.1'],
        ]
    ],
];