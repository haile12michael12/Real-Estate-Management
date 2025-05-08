<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    
    protected $fillable = [
        'name'
    ];

    public function properties()
    {
        return $this->hasMany(Property::class, 'home_type', 'name');
    }

    public function getAllCategories() {
        $stmt = $this->conn->prepare("SELECT * FROM categories");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getCategoryById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM categories WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function create($name) {
        $stmt = $this->conn->prepare("INSERT INTO categories (name) VALUES (:name)");
        return $stmt->execute([':name' => $name]);
    }

    public function update($id, $name) {
        $stmt = $this->conn->prepare("UPDATE categories SET name = :name WHERE id = :id");
        return $stmt->execute([':name' => $name, ':id' => $id]);
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM categories WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}