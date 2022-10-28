<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use App\Models\About;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    //
    public function about(){
        
        $about = About::first();

        return response()->view('al_madina.about.about',['about' => $about]);
    }
}
