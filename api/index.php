<?php

/**
 * Vercel PHP Entry Point
 * This file bridges the serverless environment to Laravel's main entry point.
 */

define('LARAVEL_START', microtime(true));

// Manually set env for serverless to avoid cache issues
// This prevents Laravel from using fixed paths in bootstrap/cache
putenv('APP_SERVICES_CACHE=/tmp/services.php');
putenv('APP_PACKAGES_CACHE=/tmp/packages.php');
putenv('APP_CONFIG_CACHE=/tmp/config.php');
putenv('APP_ROUTES_CACHE=/tmp/routes.php');

// Register the Composer autoloader...
require __DIR__ . '/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var \Illuminate\Foundation\Application $app */
$app = require_once __DIR__ . '/../bootstrap/app.php';

// Ensure the storage paths are writable for serverless (Vercel)
// We use the /tmp directory which is the only writable directory on Vercel
$app->useStoragePath('/tmp/storage');
if (!is_dir('/tmp/storage/framework/views')) {
    mkdir('/tmp/storage/framework/views', 0755, true);
}

// Laravel 11/12 request capture and handling
$app->handleRequest(\Illuminate\Http\Request::capture());
