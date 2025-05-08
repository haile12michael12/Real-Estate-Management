<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    protected $table = 'requests';
    
    protected $fillable = [
        'name',
        'email',
        'phone',
        'prop_id',
        'user_id',
        'author'
    ];

    public function property()
    {
        return $this->belongsTo(Property::class, 'prop_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getAllRequests() {
        $stmt = $this->conn->prepare("SELECT * FROM requests");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $stmt = $this->conn->prepare("INSERT INTO requests (property_id, user_id, message, status) 
            VALUES (:property_id, :user_id, :message, :status)");
        return $stmt->execute($data);
    }

    public function updateStatus($id, $status) {
        $stmt = $this->conn->prepare("UPDATE requests SET status = :status WHERE id = :id");
        return $stmt->execute([':status' => $status, ':id' => $id]);
    }
}