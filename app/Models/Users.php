<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';
    
    protected $fillable = [
        'username',
        'email',
        'mypassword'
    ];

    protected $hidden = [
        'mypassword'
    ];

    public function favorites()
    {
        return $this->hasMany(Fav::class);
    }

    public function requests()
    {
        return $this->hasMany(Request::class);
    }
}