<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $table = 'props';
    
    protected $fillable = [
        'name',
        'location',
        'image',
        'price',
        'beds',
        'baths',
        'sq_ft',
        'home_type',
        'year_built',
        'type',
        'price_sqft',
        'description',
        'admin_name'
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_name', 'adminname');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'home_type', 'name');
    }

    public function relatedImages()
    {
        return $this->hasMany(RelatedImage::class, 'prop_id');
    }

    public function favorites()
    {
        return $this->hasMany(Fav::class, 'prop_id');
    }

    public function requests()
    {
        return $this->hasMany(Request::class, 'prop_id');
    }
}