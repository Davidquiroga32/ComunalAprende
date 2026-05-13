<?php

return [
    'key_id'     => env('B2_KEY_ID'),
    'app_key'    => env('B2_APP_KEY'),
    'bucket'     => env('B2_BUCKET', 'ComunalAprende-media'),
    'endpoint'   => env('B2_ENDPOINT', 'https://s3.us-east-005.backblazeb2.com'),
    'public_url' => env('B2_PUBLIC_URL', 'https://f005.backblazeb2.com/file/ComunalAprende-media'),
    'region'     => env('B2_REGION', 'us-east-005'),
];