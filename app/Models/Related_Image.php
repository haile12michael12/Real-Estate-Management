<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RelatedImage extends Model
{
    protected $table = 'related_images';
    
    protected $fillable = [
        'image',
        'prop_id'
    ];

    public function property()
    {
        return $this->belongsTo(Property::class, 'prop_id');
    }
}
