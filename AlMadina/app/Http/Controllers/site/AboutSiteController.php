<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\TeamMember;
use Illuminate\Http\Request;

class AboutSiteController extends Controller
{
    public function about(){

        $about = About::all();
        $team_members = TeamMember::orderBy('id', 'desc')->get();

        return view('al_madina.about.about',compact('about','team_members'));
    }
}
