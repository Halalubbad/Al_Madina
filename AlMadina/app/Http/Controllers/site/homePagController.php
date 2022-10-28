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

        // $size = Tag::where('name','=','size')->get();
        // $size = Tag::where('name' ,'=' ,'size')->get();
        // $sizeTags = Tag::where('parent_id','=',$size[0]->id)->get();
        $sizeTag = Tag::where('name', '=', 'size')->with('childs')->orderBy('id', 'asc')->get();
        $product_tags = ProductTag::all();

        $parents = Tag::where('parent_id','=',0)->with('childs')->orderBy('id', 'asc')->get();
        
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
             'sizeTag' => $sizeTag,
            //  'size' => $size,
             'albums' => $albums,
             'theysaids' => $theysaids,
             'parents' => $parents,
             'product_tags' => $product_tags
            ]
        );
    }

    // public function 

}
