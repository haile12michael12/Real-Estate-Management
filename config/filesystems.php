<?php

return [
    'default' => env('FILESYSTEM_DRIVER', 'local'),

    'disks' => [
        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],

        'properties' => [
            'driver' => 'local',
            'root' => public_path('uploads/properties'),
            'url' => env('APP_URL').'/uploads/properties',
            'visibility' => 'public',
        ],
    ],

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],
]; 