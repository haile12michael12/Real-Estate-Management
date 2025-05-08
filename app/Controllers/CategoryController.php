<?php

namespace App\Controllers;

use App\Models\Category;

class CategoryController {
    private $categoryModel;

    public function __construct() {
        $db = require_once __DIR__ . "/../../config/config.php";
        $this->categoryModel = new Category($db);
    }

    public function index() {
        return $this->categoryModel->getAllCategories();
    }

    public function store() {
        if(isset($_POST['submit'])) {
            $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
            if($this->categoryModel->create($name)) {
                $_SESSION['success'] = "Category created successfully";
                header("location: " . ADMINURL . "/categories");
                exit();
            }
        }
    }

    public function update($id) {
        if(isset($_POST['submit'])) {
            $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
            if($this->categoryModel->update($id, $name)) {
                $_SESSION['success'] = "Category updated successfully";
                header("location: " . ADMINURL . "/categories");
                exit();
            }
        }
    }

    public function delete($id) {
        if($this->categoryModel->delete($id)) {
            $_SESSION['success'] = "Category deleted successfully";
            header("location: " . ADMINURL . "/categories");
            exit();
        }
    }
}