<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

if (($_SERVER['REQUEST_URI'] ?? '') === '/__debug') {
    header('Content-Type: application/json');

    echo json_encode([
        'php_version' => PHP_VERSION,
        'app_key_exists' => !empty(getenv('APP_KEY')),
        'app_env' => getenv('APP_ENV'),
        'app_debug' => getenv('APP_DEBUG'),
        'db_connection' => getenv('DB_CONNECTION'),
        'db_host_exists' => !empty(getenv('DB_HOST')),
        'db_database' => getenv('DB_DATABASE'),
        'db_username' => getenv('DB_USERNAME'),
        'db_password_exists' => !empty(getenv('DB_PASSWORD')),
        'view_compiled_path' => getenv('VIEW_COMPILED_PATH'),
        'cache_store' => getenv('CACHE_STORE'),
        'session_driver' => getenv('SESSION_DRIVER'),
    ], JSON_PRETTY_PRINT);

    exit;
}

try {
    require __DIR__ . '/../public/index.php';
} catch (Throwable $e) {
    http_response_code(500);
    header('Content-Type: text/plain');

    echo "PHP/Laravel Fatal Error\n\n";
    echo "Message: " . $e->getMessage() . "\n\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n\n";
    echo "Trace:\n" . $e->getTraceAsString();

    exit;
}