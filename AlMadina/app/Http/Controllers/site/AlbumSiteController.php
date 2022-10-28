<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\Controller;
use App\Models\Album;
use Illuminate\Http\Request;

class AlbumSiteController extends Controller
{
    //
    public function albums()
    {
        $albums = Album::whereHas('album_images')->withCount('album_images')->get();
        return view('al_madina.albums.albums', compact('albums'));
    }
}
