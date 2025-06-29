<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    protected $fillable = [
        'title', 'price', 'category_id', 'brand_id', 'size', 'color',
        'material', 'stock', 'fit', 'style', 'description', 'highlights',
        'main_image', 'is_featured', 'status'
    ];

    public function images()
    {
        return $this->hasMany(CollectionImage::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

     public function user(){
        return $this->belongsTo(User::class);
    }





}

