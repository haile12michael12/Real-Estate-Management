<?php

namespace App\Core;

abstract class Controller {
    protected $db;
    protected $session;

    public function __construct() {
        $this->db = Database::getInstance();
        $this->session = new Session();
        $this->session->init();
    }

    protected function view($view, $data = []) {
        extract($data);
        
        $viewPath = __DIR__ . "/../Views/{$view}.php";
        if (file_exists($viewPath)) {
            require_once $viewPath;
        } else {
            throw new \Exception("View {$view} not found");
        }
    }

    protected function redirect($url) {
        header("Location: {$url}");
        exit();
    }

    protected function json($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit();
    }

    protected function validate($data, $rules) {
        $errors = [];
        
        foreach ($rules as $field => $rule) {
            if (strpos($rule, 'required') !== false && empty($data[$field])) {
                $errors[$field] = ucfirst($field) . " is required";
            }
            
            if (isset($data[$field])) {
                if (strpos($rule, 'email') !== false && !filter_var($data[$field], FILTER_VALIDATE_EMAIL)) {
                    $errors[$field] = "Invalid email format";
                }
                
                if (strpos($rule, 'min:') !== false) {
                    preg_match('/min:(\d+)/', $rule, $matches);
                    $min = $matches[1];
                    if (strlen($data[$field]) < $min) {
                        $errors[$field] = ucfirst($field) . " must be at least {$min} characters";
                    }
                }
                
                if (strpos($rule, 'max:') !== false) {
                    preg_match('/max:(\d+)/', $rule, $matches);
                    $max = $matches[1];
                    if (strlen($data[$field]) > $max) {
                        $errors[$field] = ucfirst($field) . " must not exceed {$max} characters";
                    }
                }
            }
        }
        
        return $errors;
    }

    protected function isPost() {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    protected function isGet() {
        return $_SERVER['REQUEST_METHOD'] === 'GET';
    }

    protected function getPost($key = null) {
        if ($key === null) {
            return $_POST;
        }
        return $_POST[$key] ?? null;
    }

    protected function getQuery($key = null) {
        if ($key === null) {
            return $_GET;
        }
        return $_GET[$key] ?? null;
    }

    protected function requireAuth() {
        if (!$this->session->isLoggedIn()) {
            $this->redirect(Config::getAdminUrl() . '/admins/login-admins.php');
        }
    }

    protected function setFlash($type, $message) {
        $this->session->setFlash($type, $message);
    }

    protected function getFlash($type) {
        return $this->session->getFlash($type);
    }

    protected function hasFlash($type) {
        return $this->session->hasFlash($type);
    }
}
