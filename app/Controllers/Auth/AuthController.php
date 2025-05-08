<?php

namespace App\Controllers;

use App\Models\User;

class AuthController {
    private $userModel;
    private $conn;

    public function __construct() {
        $this->conn = require_once __DIR__ . "/../../config/config.php";
        $this->userModel = new User($this->conn);
    }

    public function register() {
        if(isset($_SESSION['username'])) {
            header("location: " . APPURL);
            exit();
        }

        if(isset($_POST['submit'])) {
            if(empty($_POST['username']) || empty($_POST['email']) || empty($_POST['password'])) {
                $_SESSION['error'] = "Some inputs are empty";
                return false;
            }

            $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'];

            if($this->userModel->register($username, $email, $password)) {
                header("location: " . APPURL . "/auth/login.php");
                exit();
            } else {
                $_SESSION['error'] = "Registration failed";
                return false;
            }
        }
        return true;
    }

    public function login() {
        if(isset($_SESSION['username'])) {
            header("location: " . APPURL);
            exit();
        }

        if(isset($_POST['submit'])) {
            if(empty($_POST['email']) || empty($_POST['password'])) {
                $_SESSION['error'] = "Some inputs are empty";
                return false;
            }

            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'];

            $user = $this->userModel->login($email, $password);
            if($user) {
                $_SESSION['username'] = $user['username'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['user_id'] = $user['id'];
                header("location: " . APPURL);
                exit();
            } else {
                $_SESSION['error'] = "Invalid credentials";
                return false;
            }
        }
        return true;
    }

    public function logout() {
        session_start();
        session_unset();
        session_destroy();
        header("location: " . APPURL);
        exit();
    }
}