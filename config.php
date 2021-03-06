<?php

// Main array with all settings
return [
    // Choose your timezone, all list of time zones 
    // you can find in http://php.net/manual/en/timezones.php
    'timezone' => 'UTC',

    // Application locale
    'locale' => 'en',

    // Uses then main locale don't working
    'fallbackLocale' => 'ru',

    // Debug mode; Set false value in production
    'debug' => true,

    // Set true to protect your forms from CSRF attacks
    'CSRFProtection' => true,

    // Home page url
    'homeURL' => '/',

    // Base template for HTML page
    'template' => 'main',

    // Base URL to web components
    'webPath' => '/web/',

    // Path to page on which the redirect will be sent on error 404
    '404page' => '404.php',

    // HTML page options
    'html' => [
        // HTML language
        'lang' => 'en',

        // HTML charset
        'charset' => 'UTF-8'
    ],

    // Data base options
    'db' => [
        // Default DBMS. Can be "mysql", "pgsql", "sqlite"
        'dbms' => 'mysql',

        // Settings for MySQL DBMS
        'mysql' => [
            'host' => '127.0.0.1',
            'user' => 'root',
            'password' => 'secret',
            'name' => 'database',
            'charset' => 'utf8'
        ],

        // Settings for PostgreSQL DBMS
        'pgsql' => [
            'host' => '127.0.0.1',
            'user' => 'root',
            'password' => 'secret',
            'name' => 'database',
            'charset' => 'utf8'
        ],

        // Settings for SQLite DBMS
        'sqlite' => [
            // Path to sqlite file
            'path' => BASE_DIR . '/database/yourdb.sqlite'
        ],

        // PDO options
        'pdo_options' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    ],

    'template_engines' => [
        // Active template engine
        'engine' => 'PHP',

        'PHP' => [
            'file_extension' => 'php'
        ],

        'twig' => [
            'file_extension' => 'twig',
            'config' => [
                'cache' => BASE_DIR . '/store/cache/twig',
                'debug' => true
            ]
        ],

        'smarty' => [
            'file_extension' => 'php',
            'config' => [
                'cache_dir' => BASE_DIR . '/store/cache/smarty',
                'compile_dir' => BASE_DIR . '/store/cache/smarty',
                'debugging' => true
            ]
        ]
    ],

    'caching' => [
        'driver' => 'memcached',

        'memcached' => [
            [
                'host' => '127.0.0.1',
                'port' => 11211
            ]
        ],

        'redis' => [
            'scheme' => 'tcp',
            'host' => '127.0.0.1',
            'port' => 6379
        ]
    ]
];
