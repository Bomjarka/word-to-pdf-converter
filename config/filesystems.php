<?php

return [
    'disks' => [
        'documents' => [
            'path' => 'public/documents',
            'driver' => 'local',
            'root' => storage_path('app/public/documents'),
            'url' => env('APP_URL') . '/storage/documents',
            'visibility' => 'public',
            'throw' => false,
        ],
    ],
];
