<?php

$db = require __DIR__ . '/db.php';

return [
    'components' => [
        'db' => [
            'dsn' => 'mysql:host=127.0.0.1;dbname=db_order_flow',
            'username' => getenv('OMS_AUTH_DB_USER'),
            'password' => getenv('OMS_AUTH_DB_PASS'),
            // Schema cache options (for production environment)
            'enableSchemaCache' => true,
            'schemaCacheDuration' => 60,
            'schemaCache' => 'cache',
        ],
        'authDb' => [
            'dsn' => 'mysql:host=127.0.0.1;dbname=db_twinkle_ucenter',
            'username' => getenv('OMS_AUTH_DB_USER'),
            'password' => getenv('OMS_AUTH_DB_PASS'),
            // Schema cache options (for production environment)
            'enableSchemaCache' => true,
            'schemaCacheDuration' => 60,
            'schemaCache' => 'cache',
        ],
        'cache' => [
            'keyPrefix' => 'oms:',
        ],
    ],
    'modules' => [

    ]
];