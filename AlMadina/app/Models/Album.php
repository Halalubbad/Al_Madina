<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    use HasFactory;

    public function album_images(){
        return $this->hasMany(AlbumImage::class, 'album_id' , 'id');
    }
}
