<?php

namespace App\Core;

// Load configuration
Config::load(__DIR__ . '/../../config/config.php');
Config::loadEnv();

// Initialize session
Session::init();

// Set error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set default timezone
date_default_timezone_set('UTC');

// Define constants
define('APPURL', Config::getAppUrl());
define('ADMINURL', Config::getAdminUrl());
define('UPLOADPATH', Config::getUploadPath());

// Autoload classes
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/../';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

// Handle errors
set_error_handler(function($errno, $errstr, $errfile, $errline) {
    if (!(error_reporting() & $errno)) {
        return false;
    }

    switch ($errno) {
        case E_USER_ERROR:
            echo "<b>Fatal Error</b> [$errno] $errstr<br />\n";
            echo "Fatal error on line $errline in file $errfile";
            exit(1);
            break;

        case E_USER_WARNING:
            echo "<b>Warning</b> [$errno] $errstr<br />\n";
            break;

        case E_USER_NOTICE:
            echo "<b>Notice</b> [$errno] $errstr<br />\n";
            break;

        default:
            echo "Unknown error type: [$errno] $errstr<br />\n";
            break;
    }

    return true;
});

// Handle exceptions
set_exception_handler(function($e) {
    echo "<h1>Error</h1>";
    echo "<p>An error occurred: " . $e->getMessage() . "</p>";
    if (Config::get('app_debug', false)) {
        echo "<h2>Stack Trace:</h2>";
        echo "<pre>" . $e->getTraceAsString() . "</pre>";
    }
}); 