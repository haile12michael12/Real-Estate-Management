<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'admins';
    
    protected $fillable = [
        'adminname',
        'email',
        'mypassword'
    ];

    protected $hidden = [
        'mypassword'
    ];

    public function properties()
    {
        return $this->hasMany(Property::class, 'admin_name', 'adminname');
    }

    public function login($email, $password) {
        $stmt = $this->conn->prepare("SELECT * FROM admins WHERE email = :email");
        $stmt->execute([':email' => $email]);
        $admin = $stmt->fetch(\PDO::FETCH_ASSOC);

        if($stmt->rowCount() > 0 && password_verify($password, $admin['mypassword'])) {
            return $admin;
        }
        return false;
    }

    public function getAllAdmins() {
        $stmt = $this->conn->prepare("SELECT * FROM admins");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}