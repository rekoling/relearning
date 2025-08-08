<?php

// Autoload dependencies
require_once __DIR__ . '/../vendor/autoload.php';

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// Set error reporting based on environment
if ($_ENV['APP_ENV'] === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// Configure session settings
$sessionConfig = require __DIR__ . '/../config/app.php';
session_set_cookie_params([
    'lifetime' => $sessionConfig['session']['lifetime'],
    'path' => '/',
    'domain' => '',
    'secure' => $sessionConfig['session']['secure'],
    'httponly' => $sessionConfig['session']['httponly'],
    'samesite' => $sessionConfig['session']['samesite']
]);

// Set timezone
date_default_timezone_set('Asia/Jakarta');

// Custom error handler for production
if ($_ENV['APP_ENV'] === 'production') {
    set_error_handler(function($severity, $message, $file, $line) {
        error_log("Error: {$message} in {$file} on line {$line}");
        
        if (!(error_reporting() & $severity)) {
            return;
        }
        
        throw new ErrorException($message, 0, $severity, $file, $line);
    });
}

// Global helper functions
function config(string $key, $default = null) {
    static $configs = [];
    
    $keys = explode('.', $key);
    $configFile = array_shift($keys);
    
    if (!isset($configs[$configFile])) {
        $configPath = __DIR__ . "/../config/{$configFile}.php";
        if (file_exists($configPath)) {
            $configs[$configFile] = require $configPath;
        } else {
            return $default;
        }
    }
    
    $value = $configs[$configFile];
    foreach ($keys as $k) {
        if (is_array($value) && isset($value[$k])) {
            $value = $value[$k];
        } else {
            return $default;
        }
    }
    
    return $value;
}

function asset(string $path): string {
    $baseUrl = rtrim(config('app.url'), '/');
    return $baseUrl . '/' . ltrim($path, '/');
}

function url(string $path = ''): string {
    $baseUrl = rtrim(config('app.url'), '/');
    return $baseUrl . '/' . ltrim($path, '/');
}

function old(string $key, $default = ''): string {
    return $_SESSION['old_input'][$key] ?? $default;
}

function error(string $key): ?string {
    return $_SESSION['errors'][$key][0] ?? null;
}

function flash(string $key, $default = null) {
    $value = $_SESSION['flash'][$key] ?? $default;
    unset($_SESSION['flash'][$key]);
    return $value;
}

function setFlash(string $key, $value): void {
    $_SESSION['flash'][$key] = $value;
}