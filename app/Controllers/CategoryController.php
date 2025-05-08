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
        $categories = $this->categoryModel->getAllCategories();
        require_once __DIR__ . "/../Views/admin-panel/categories-admins/show-categories.php";
    }

    public function create() {
        require_once __DIR__ . "/../Views/admin-panel/categories-admins/create-category.php";
    }

    public function store() {
        if(isset($_POST['submit'])) {
            if(empty($_POST['name'])) {
                $_SESSION['error'] = "Category name is required";
                header("location: " . ADMINURL . "/categories-admins/create-category.php");
                exit();
            }

            $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
            $final_name = str_replace(' ', '-', trim($name));

            if($this->categoryModel->create($final_name)) {
                $_SESSION['success'] = "Category created successfully";
                header("location: " . ADMINURL . "/categories-admins/show-categories.php");
                exit();
            } else {
                $_SESSION['error'] = "Failed to create category";
                header("location: " . ADMINURL . "/categories-admins/create-category.php");
                exit();
            }
        }
    }

    public function edit($id) {
        $category = $this->categoryModel->getCategoryById($id);
        if(!$category) {
            $_SESSION['error'] = "Category not found";
            header("location: " . ADMINURL . "/categories-admins/show-categories.php");
            exit();
        }
        require_once __DIR__ . "/../Views/admin-panel/categories-admins/update-category.php";
    }

    public function update($id) {
        if(isset($_POST['submit'])) {
            if(empty($_POST['name'])) {
                $_SESSION['error'] = "Category name is required";
                header("location: " . ADMINURL . "/categories-admins/update-category.php?id=" . $id);
                exit();
            }

            $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
            $final_name = str_replace(' ', '-', trim($name));

            if($this->categoryModel->update($id, $final_name)) {
                $_SESSION['success'] = "Category updated successfully";
                header("location: " . ADMINURL . "/categories-admins/show-categories.php");
                exit();
            } else {
                $_SESSION['error'] = "Failed to update category";
                header("location: " . ADMINURL . "/categories-admins/update-category.php?id=" . $id);
                exit();
            }
        }
    }

    public function destroy($id) {
        if($this->categoryModel->delete($id)) {
            $_SESSION['success'] = "Category deleted successfully";
        } else {
            $_SESSION['error'] = "Failed to delete category";
        }
        header("location: " . ADMINURL . "/categories-admins/show-categories.php");
        exit();
    }
}