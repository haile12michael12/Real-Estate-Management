<?php

namespace App\Models;

abstract class BaseModel {
    protected $conn;

    public function __construct($db) {
        $this->conn = $db;
    }
}