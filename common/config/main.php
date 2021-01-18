<?php

$env = require __DIR__ . "/../../common/config/env.php";

$params = [
    'db.allocate' => [
        '{{%user}}' => 'db',
        '{{%node}}' => 'db',
        '{{%partner}}' => 'db',
    ],
    'db.env' => $env,
];

$config = [
    'bootstrap' => [
        'queue',
    ],
    'components' => [
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
        'redis' => [
            'class' => \lingyin\predis\Connection::class,
            'parameters' => [
                'host' => $env['redis_host'],
                'port' => 6379,
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
        'snowflake' => [
            'class' => \lingyin\common\components\snowflake\Snowflake::class,
            'workerId' => getenv('SNOWFLAKE_WORKER_ID') ?: 0,
        ],
        'queue' => [
            'class' => \yii\queue\redis\Queue::class,
        ]
    ],
    'params' => $params,
];

if (file_exists($file = __DIR__ . '/db_partner_config.php')) {
    $config['params']['db.partner.config'] = require($file);
}

return $config;