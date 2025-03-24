<?php

return [

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],  // Allow all HTTP methods (GET, POST, etc.)

    'allowed_origins' => ['*'],

    'allowed_headers' => ['*'],  // Allow all headers

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true,  // Important for Sanctum cookies
];
