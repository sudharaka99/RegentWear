<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CollectionImage extends Model
{
    protected $fillable = ['collection_id', 'image'];

    public function collection()
    {
        return $this->belongsTo(Collection::class);
    }

     public function user(){
        return $this->belongsTo(User::class);
    }
}

