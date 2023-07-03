<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\Album;
use App\Models\Brand;
use App\Models\Offer;
use App\Models\Product;
use App\Models\ProductTag;
use App\Models\Setting;
use App\Models\Slider;
use App\Models\Tag;
use App\Models\Theysaid;

class homePagController extends Controller
{
    //
    
    public function home(){
        
        $sliders = Slider::all();

        $abouts = About::all();

        $settings = Setting::all();

        $products = Product::with('tags')->paginate(8);

        $brands = Brand::all();

        $parents = Tag::where('parent_id','=',0)->with('childs')->orderBy('id', 'asc')->get();

        $sizeTagType = Tag::where('name', 'size')->first();
        
        $offers = Offer::with('conditions')->get();

        $albums = Album::wherehas('album_images')->get();
        
        $theysaids = Theysaid::all();
        // $album_images = AlbumImage::paginate(6);

        return response()->view('al_madina.almadinaHome.almadinaHome',
            ['sliders' => $sliders,
             'abouts' => $abouts,
             'settings' => $settings,
             'products' => $products,
             'brands' => $brands,
             'offers' => $offers,
             'albums' => $albums,
             'theysaids' => $theysaids,
             'parents' => $parents,
             'sizeTagType' => $sizeTagType
            ]
        );
    }

    // public function 

}
