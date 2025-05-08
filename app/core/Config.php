<?php

namespace App\Core;

class Config {
    private static $config = [];

    public static function load($file) {
        if (file_exists($file)) {
            $config = require $file;
            self::$config = array_merge(self::$config, $config);
        }
    }

    public static function get($key, $default = null) {
        return self::$config[$key] ?? $default;
    }

    public static function set($key, $value) {
        self::$config[$key] = $value;
    }

    public static function all() {
        return self::$config;
    }

    public static function has($key) {
        return isset(self::$config[$key]);
    }

    public static function loadEnv() {
        $envFile = __DIR__ . '/../../.env';
        if (file_exists($envFile)) {
            $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                if (strpos($line, '=') !== false && strpos($line, '#') !== 0) {
                    list($key, $value) = explode('=', $line, 2);
                    $key = trim($key);
                    $value = trim($value);
                    
                    // Remove quotes if present
                    if (strpos($value, '"') === 0 || strpos($value, "'") === 0) {
                        $value = substr($value, 1, -1);
                    }
                    
                    putenv("$key=$value");
                    $_ENV[$key] = $value;
                    $_SERVER[$key] = $value;
                }
            }
        }
    }

    public static function getAppUrl() {
        return self::get('app_url', 'http://localhost');
    }

    public static function getAdminUrl() {
        return self::get('admin_url', self::getAppUrl() . '/admin');
    }

    public static function getUploadPath() {
        return self::get('upload_path', __DIR__ . '/../../public/uploads');
    }

    public static function getDatabaseConfig() {
        return [
            'host' => self::get('db_host', 'localhost'),
            'name' => self::get('db_name', 'real_estate'),
            'user' => self::get('db_user', 'root'),
            'pass' => self::get('db_pass', ''),
            'charset' => self::get('db_charset', 'utf8mb4')
        ];
    }
} 