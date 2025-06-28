<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    use HasFactory;

    public function images()
{
    return $this->hasMany(CollectionImage::class); // model for `collections_image`
}
}
