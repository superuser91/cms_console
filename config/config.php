<?php

return [
    'console' => [
        'prefix' => '/admin/console',
        'middleware' => ['auth:admin'],
        'pjax_container_id' => 'kt_content',
        'white_list' => [
            'up',
            'down',
            'list',
            'db',
            'env',
            'optimize',
            'config:cache',
            'config:clear',
            'optimize:clear',
            'cache:clear',
            'cache:forget',
            'ckfinder:download',
            'queue:restart',
            'route:list',
            'scan:payment',
            'schedule:run',
            'schedule:list',
            'export:log',
        ]
    ]
];
