<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

if (! $app->bound('files')) {
    $app->register(Illuminate\Filesystem\FilesystemServiceProvider::class);
}

if (! $app->bound('translator')) {
    $app->register(Illuminate\Translation\TranslationServiceProvider::class);
}

if (! $app->bound('view')) {
    $app->register(Illuminate\View\ViewServiceProvider::class);
}

$app->handleRequest(Request::capture());
