<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => env('CORS_ALLOWED_METHODS') ? explode(',', env('CORS_ALLOWED_METHODS')) : ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'],

    'allowed_origins' => env('CORS_ALLOWED_ORIGINS') ? explode(',', env('CORS_ALLOWED_ORIGINS')) : (env('APP_ENV') === 'production' ? [] : ['*']),

    'allowed_origins_patterns' => env('CORS_ALLOWED_ORIGINS_PATTERNS') ? explode(',', env('CORS_ALLOWED_ORIGINS_PATTERNS')) : [],

    'allowed_headers' => env('CORS_ALLOWED_HEADERS') ? explode(',', env('CORS_ALLOWED_HEADERS')) : ['Content-Type', 'Authorization', 'X-Requested-With', 'X-CSRF-TOKEN'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => false,

];
