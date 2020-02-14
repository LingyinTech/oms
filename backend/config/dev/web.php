<?php

return [
    'bootstrap' => ['debug', 'gii'],
    'as access' => [
        'allowActions' => [
            'debug/*',
        ],
        'supperAdmin' => [
            'admin','actors315'
        ]
    ],
    'components' => [
        'db' => [
            'dsn' => 'mysql:host=127.0.0.1;dbname=db_order_flow',
            'username' => 'root',
            'password' => 'qqWW1019!@#',
        ],
        'authDb' => [
            'dsn' => 'mysql:host=127.0.0.1;dbname=db_twinkle_ucenter',
            'username' => 'root',
            'password' => 'qqWW1019!@#',
        ],
        'cache' => [
            'keyPrefix' => 'lingyin:oms:',
        ],
    ],
    'modules' => [
        'debug' => [
            'class' => 'yii\debug\Module',
            // uncomment the following to add your IP if you are not connecting from localhost.
            'allowedIPs' => ['127.0.0.1', '::1', '192.168.96.1'],
        ],
        'gii' => [
            'class' => 'yii\gii\Module',
            // uncomment the following to add your IP if you are not connecting from localhost.
            'allowedIPs' => ['127.0.0.1', '::1', '192.168.96.1'],
        ]
    ],
];