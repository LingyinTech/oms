<?php

return [
    'components' => [
        'snowflake' => [
            'class' => \lingyin\common\components\snowflake\Snowflake::class,
            'workerId' => getenv('SNOWFLAKE_WORKER_ID') ?: 0,
            'dataCenterId' => getenv('SNOWFLAKE_DATA_CENTER_ID') ?: 0,
        ]
    ],
    'params' => [
        'db.allocate' => [
            '{{%user}}' => 'db',
            '{{%node}}' => 'db',
            '{{%user_info}}' => 'db',
            '{{%partner}}' => 'db',
        ]
    ]
];