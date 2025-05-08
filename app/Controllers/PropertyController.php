<?php

namespace App\Controllers;

use App\Models\Property;

class PropertyController {
    private $propertyModel;

    public function __construct() {
        $db = require_once __DIR__ . "/../../config/config.php";
        $this->propertyModel = new Property($db);
    }

    public function index() {
        return $this->propertyModel->getAllProperties();
    }

    public function store() {
        if(isset($_POST['submit'])) {
            // Handle file upload
            $image = $_FILES['image']['name'];
            $tmp_name = $_FILES['image']['tmp_name'];
            move_uploaded_file($tmp_name, "images/" . $image);

            $data = [
                ':title' => filter_var($_POST['title'], FILTER_SANITIZE_STRING),
                ':description' => filter_var($_POST['description'], FILTER_SANITIZE_STRING),
                ':price' => filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_FLOAT),
                ':location' => filter_var($_POST['location'], FILTER_SANITIZE_STRING),
                ':type' => $_POST['type'],
                ':status' => $_POST['status'],
                ':image' => $image,
                ':category_id' => $_POST['category_id'],
                ':user_id' => $_SESSION['user_id']
            ];

            if($this->propertyModel->create($data)) {
                $_SESSION['success'] = "Property created successfully";
                header("location: " . APPURL . "/properties");
                exit();
            }
        }
    }
}