<?php

namespace App\Core;

class Session {
    public static function init() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function set($key, $value) {
        $_SESSION[$key] = $value;
    }

    public static function get($key) {
        return $_SESSION[$key] ?? null;
    }

    public static function has($key) {
        return isset($_SESSION[$key]);
    }

    public static function remove($key) {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }

    public static function destroy() {
        session_destroy();
    }

    public static function flash($key, $message = null) {
        if ($message === null) {
            $message = self::get($key);
            self::remove($key);
            return $message;
        }
        
        self::set($key, $message);
    }

    public static function isLoggedIn() {
        return self::has('adminname');
    }

    public static function requireLogin() {
        if (!self::isLoggedIn()) {
            header("location: " . ADMINURL . "/admins/login-admins.php");
            exit();
        }
    }

    public static function setFlash($type, $message) {
        self::flash('flash_' . $type, $message);
    }

    public static function getFlash($type) {
        return self::flash('flash_' . $type);
    }

    public static function hasFlash($type) {
        return self::has('flash_' . $type);
    }
} 