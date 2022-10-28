<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Date;

class News extends Model
{
    use HasFactory;

    public function comments()
    {
        return $this->hasMany(Comment::class, 'news_id', 'id');
    }

    // function createDate($date)
    // {
    //     $edate = Carbon::createFromFormat('d/m/Y', $date)->format('d-m-Y') ;
    //     return $edate;
    // }

    // public function setPublishedAtAttribute($value)
    // {
    //     $this->publishedatdate['published_at'] = Carbon::createFromFormat('dd-mm-YY', $value);
    // }
}
