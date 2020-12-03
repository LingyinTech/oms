<?php

$env = require __DIR__. "/../../../common/config/prod/env.php";

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