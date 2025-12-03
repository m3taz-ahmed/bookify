<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Vite Configuration
    |--------------------------------------------------------------------------
    |
    | Configure how Vite builds and serves your assets.
    |
    */

    'entry_points' => [
        'resources/css/app.css',
        'resources/js/app.js',
    ],

    'asset_patterns' => [
        '/\.css$/',
        '/\.js$/',
    ],

    'public_directory' => 'public',

    'build_directory' => 'build',

    'hot_file' => 'hot',

    'dev_server' => [
        'host' => 'localhost',
        'port' => 5173,
        'https' => false,
        'strict_port' => true,
    ],
];