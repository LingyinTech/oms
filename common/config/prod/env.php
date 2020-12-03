<?php

return [
    'host' => getenv('OMS_DB_HOST') ?: 'mysql',
    'db' => getenv('OMS_DB_NAME') ?: 'db_oms',
    'user' => getenv('OMS_DB_USER') ?: 'root',
    'pass' => getenv('OMS_DB_PASS') ?: '',
    'root.pass' => getenv('ROOT_DB_PASS') ?: '',
    'redis_host' => getenv('OMS_REDIS_HOST') ?: 'redis-master',
    'redis_prefix' => getenv('OMS_REDIS_KEY_PREFIX') ?: 'oms:',
];