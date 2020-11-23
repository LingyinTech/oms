<?php

return [
    'components' => [
        'db' => [
            'dsn' => 'mysql:host=mysql;dbname=db_oms',
            'username' => getenv('OMS_DB_USER'),
            'password' => getenv('OMS_DB_PASS'),
            'enableSchemaCache' => true,
            'schemaCacheDuration' => 60,
            'schemaCache' => 'cache',
        ],
        'cache' => [
            'keyPrefix' => 'oms:',
            'redis' => [
                'parameters' => [
                    'host' => 'redis-master',
                    'port' => 6379,
                ],

            ]
        ],
    ],
    'modules' => [

    ]
];