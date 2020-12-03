<?php

$env = require __DIR__. "/../../../common/config/prod/env.php";

return [
    'components' => [
        'db' => [
            'dsn' => "mysql:host={$env['host']};dbname={$env['db']}",
            'username' => $env['user'],
            'password' => $env['pass'],
        ],
    ],
    'params' => [
        'db.env' => $env,
    ]
];