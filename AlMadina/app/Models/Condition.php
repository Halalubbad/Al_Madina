<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Condition extends Model
{
    use HasFactory;

    public function offer(){
        return $this->belongsTo(Offer::class,'offer_id','id');
    }
}
