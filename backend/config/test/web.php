<?php

$db = require __DIR__ . '/db.php';

return [
    'bootstrap' => ['debug'],
    'components' => [
        'db' => [
            'dsn' => 'mysql:host=127.0.0.1;dbname=db_order_flow_test',
            'username' => getenv('OMS_DB_USER'),
            'password' => getenv('OMS_DB_PASS'),
        ],
        'authDb' => [
            'dsn' => 'mysql:host=127.0.0.1;dbname=db_twinkle_ucenter_test',
            'username' => getenv('OMS_AUTH_DB_USER'),
            'password' => getenv('OMS_AUTH_DB_PASS'),
        ],
        'cache' => [
            'keyPrefix' => 'oms:',
        ],
    ],
    'modules' => [
        'debug' => [
            'class' => 'yii\debug\Module',
            // uncomment the following to add your IP if you are not connecting from localhost.
            'allowedIPs' => ['127.0.0.1', '::1'],
        ],
    ]
];