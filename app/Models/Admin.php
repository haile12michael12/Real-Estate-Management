<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $guard = 'admin';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'status' => 'boolean',
    ];

    public function isActive()
    {
        return $this->status;
    }

    public function hasRole($role)
    {
        return $this->role === $role;
    }

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