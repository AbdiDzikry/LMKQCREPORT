<?php

/**
 * Vercel PHP Entry Point
 * This file bridges the serverless environment to Laravel's main entry point.
 */

define('LARAVEL_START', microtime(true));

// Register the Composer autoloader...
require __DIR__ . '/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var \Illuminate\Foundation\Application $app */
$app = require_once __DIR__ . '/../bootstrap/app.php';

// Laravel 11's new way of handling requests
$app->handleRequest(\Illuminate\Http\Request::capture());
