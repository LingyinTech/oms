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
    ]
];