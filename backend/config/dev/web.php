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
            'dsn' => 'mysql:host=dev.local.mysql;dbname=db_oms',
            'username' => 'root',
            'password' => getenv('OMS_DB_PASS'),
        ],
        'cache' => [
            'keyPrefix' => 'oms:',
            'redis' => [
                'parameters' => [
                    'host' => 'dev.local.redis',
                    'port' => 6379,
                ],
				
            ]
        ],
    ],
    'modules' => [
        'debug' => [
            'class' => 'yii\debug\Module',
            // uncomment the following to add your IP if you are not connecting from localhost.
            'allowedIPs' => ['127.0.0.1', '::1', '172.17.0.1','172.18.0.1'],
        ],
        'gii' => [
            'class' => 'yii\gii\Module',
            // uncomment the following to add your IP if you are not connecting from localhost.
            'allowedIPs' => ['127.0.0.1', '::1', '172.17.0.1','172.18.0.1'],
        ]
    ],
];