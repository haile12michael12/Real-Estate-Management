<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fav extends Model
{
    protected $table = 'favs';
    
    protected $fillable = [
        'prop_id',
        'user_id'
    ];

    public function property()
    {
        return $this->belongsTo(Property::class, 'prop_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
