<?php

return [
    'components' => [
        'cache' => [
            'redis' => [
                'parameters' => [
                    'database' => 1
                ]
            ]
        ],
        'redis' => [
            'parameters' => [
                'database' => 1
            ],
        ],
    ],
    'params' => [
        'domain' => 'oms.lingyin99.com',
        'domain.static' => '//cos-static.lingyin99.com',
        'domain.static.version' => 'STATIC_VERSION',
        'domain.download' => '//cos-download.lingyin99.com',
    ]
];