<?php

$env = [
    'host' => getenv('OMS_DB_HOST') ?: 'mysql',
    'db' => getenv('OMS_DB_NAME') ?: 'db_oms',
    'user' => getenv('OMS_DB_USER') ?: 'root',
    'pass' => getenv('OMS_DB_PASS') ?: '',
    'redis_host' => getenv('OMS_REDIS_HOST') ?: 'redis-master',
    'redis_prefix' => getenv('OMS_REDIS_KEY_PREFIX') ?: 'oms:',
];

return [
    'components' => [
        'db' => [
            'dsn' => "mysql:host={$env['host']};dbname={$env['db']}",
            'username' => $env['user'],
            'password' => $env['pass'],
            'enableSchemaCache' => true,
            'schemaCacheDuration' => 60,
            'schemaCache' => 'cache',
        ],
        'cache' => [
            'keyPrefix' => $env['redis_prefix'],
            'redis' => [
                'parameters' => [
                    'host' => $env['redis_host'],
                    'port' => 6379,
                ],

            ]
        ],
    ],
    'modules' => [

    ]
];