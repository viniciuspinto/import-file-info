<?php

namespace Codense\ImportFileInfo;

require_once __DIR__ . '/lib/importer.php';

if (!defined(__NAMESPACE__ . '\PHP_ENV')) {
    $env = 'development';
    if (defined('\PHP_ENV') && in_array(\PHP_ENV, ['development', 'test', 'production'])) {
        $env = \PHP_ENV;
    }
    define(__NAMESPACE__ . '\PHP_ENV', $env);
}

switch (PHP_ENV) {

    case 'development':
        define('DB_HOST', 'localhost');
        define('DB_USER', 'your_user');
        define('DB_PASS', 'your_password');
        define('DB_NAME', 'myfiles_development');
        break;

    case 'test':
        define('DB_HOST', 'localhost');
        define('DB_USER', 'your_user');
        define('DB_PASS', 'your_password');
        define('DB_NAME', 'myfiles_test');
        break;

    case 'production':
        define('DB_HOST', 'localhost');
        define('DB_USER', 'your_user');
        define('DB_PASS', 'your_password');
        define('DB_NAME', 'myfiles');
        break;
}


