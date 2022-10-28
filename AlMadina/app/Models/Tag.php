<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    public function products(){
        return $this->belongsToMany(Product::class ,'product_tags', 'tag_id','product_id');
    }

    public function childs()
    {
        //Recursively call childs() relation treating each 
        //child as parent until no more childs remain
        return $this->hasMany(Tag::class, 'parent_id')->with('childs');
    }
}
