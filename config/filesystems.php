<?php

return [

    'default' => env('FILESYSTEM_DISK', 'local'),

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root'   => storage_path('app/private'),
            'serve'  => true,
            'throw'  => false,
            'report' => false,
        ],

        'public' => [
            'driver'     => 'local',
            'root'       => storage_path('app/public'),
            'url'        => rtrim(env('APP_URL', 'http://localhost'), '/').'/storage',
            'visibility' => 'public',
            'throw'      => false,
            'report'     => false,
        ],

        // ── Backblaze B2 ──────────────────────────
        'b2' => [
            'driver'                  => 's3',
            'key'                     => env('B2_KEY_ID'),
            'secret'                  => env('B2_APP_KEY'),
            'region'                  => 'us-east-005',
            'bucket'                  => env('B2_BUCKET', 'ComunalAprende-media'),
            'endpoint'                => env('B2_ENDPOINT', 'https://s3.us-east-005.backblazeb2.com'),
            'url'                     => env('B2_PUBLIC_URL', 'https://f005.backblazeb2.com/file/ComunalAprende-media'),
            'use_path_style_endpoint' => true,
            'visibility'              => 'public',
            'throw'                   => false,
            'report'                  => false,
        ],

        's3' => [
            'driver'                  => 's3',
            'key'                     => env('AWS_ACCESS_KEY_ID'),
            'secret'                  => env('AWS_SECRET_ACCESS_KEY'),
            'region'                  => env('AWS_DEFAULT_REGION'),
            'bucket'                  => env('AWS_BUCKET'),
            'url'                     => env('AWS_URL'),
            'endpoint'                => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'throw'                   => false,
            'report'                  => false,
        ],

    ],

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];