<?php

return [
    'bootstrap' => ['debug', 'gii'],
    'as access' => [
        'allowActions' => [
            'debug/*',
        ]
    ],
    'components' => [
        'db' => [
            'dsn' => 'mysql:host=127.0.0.1;dbname=db_twinkle_ucenter',
            'username' => 'root',
            'password' => 'qqWW1019!@#',
        ],
        'userDb' => [
            'dsn' => 'mysql:host=127.0.0.1;dbname=db_twinkle_ucenter',
            'username' => 'root',
            'password' => 'qqWW1019!@#',
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
    ]
];