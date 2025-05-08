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
        $stmt = $this->conn->prepare("SELECT * FROM categories ORDER BY name ASC");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getCategoryById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM categories WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function create($name) {
        try {
            $stmt = $this->conn->prepare("INSERT INTO categories (name) VALUES (:name)");
            return $stmt->execute([':name' => $name]);
        } catch (\PDOException $e) {
            return false;
        }
    }

    public function update($id, $name) {
        try {
            $stmt = $this->conn->prepare("UPDATE categories SET name = :name WHERE id = :id");
            return $stmt->execute([':name' => $name, ':id' => $id]);
        } catch (\PDOException $e) {
            return false;
        }
    }

    public function delete($id) {
        try {
            // First check if category is being used by any properties
            $stmt = $this->conn->prepare("SELECT COUNT(*) FROM props WHERE home_type = (SELECT name FROM categories WHERE id = :id)");
            $stmt->execute([':id' => $id]);
            $count = $stmt->fetchColumn();
            
            if ($count > 0) {
                return false; // Category is in use
            }
            
            $stmt = $this->conn->prepare("DELETE FROM categories WHERE id = :id");
            return $stmt->execute([':id' => $id]);
        } catch (\PDOException $e) {
            return false;
        }
    }
}