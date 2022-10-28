<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\AlbumImageController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ConditionController;
use App\Http\Controllers\ContactController as ControllersContactController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\NutritionalValueController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductTagController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\site\AboutSiteController;
use App\Http\Controllers\site\AlbumSiteController;
use App\Http\Controllers\site\ContactController;
use App\Http\Controllers\site\homePagController;
use App\Http\Controllers\site\NewsSiteController;
use App\Http\Controllers\site\OfferSiteController;
use App\Http\Controllers\site\ProductSiteController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TeamMemberController;
use App\Http\Controllers\TheysaidController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/almadina', function () {
//     return view('al_madina.almadinaHome');
// });

// Route::get('/about', function () {
//     return view('al_madina.about')->name('about');
// });

// Route::get('/products', function () {
//     return view('al_madina.products');
// });

// Route::get('/offers', function () {
//     return view('al_madina.offers');
// });

// Route::get('/news', function () {
//     return view('al_madina.news');
// });

// Route::get('/albums', function () {
//     return view('al_madina.albums');
// });

// Route::get('/contact', function () {
//     return view('al_madina.contact_us');
// });

Route::prefix('almadina')->group(function(){
//     Route::view('home', 'al_madina.almadinaHome')->name('almadina.home');
    Route::view('about', 'al_madina.about')->name('about');
    Route::view('products', 'al_madina.products')->name('products');
    Route::view('offers', 'al_madina.offers')->name('offers');
    Route::view('news', 'al_madina.news')->name('news');
    Route::view('albums', 'al_madina.albums')->name('albums');
    Route::view('contact', 'al_madina.contact_us')->name('contact');
});


// ********************************** Admin **********************************  //
Route::prefix('almadina')->middleware('guest:admin')->group(function () {
    Route::get('admin/login', [AuthController::class, 'showLoginView'])->name('almadina.login');
    Route::post('admin/login', [AuthController::class, 'login']);

    Route::get('forgot-password', [ResetPasswordController::class, 'showForgotPassword'])->name('password.forgot');
    Route::post('forgot-password', [ResetPasswordController::class, 'sendResetEmail'])->name('password.email');
    Route::get('reset-password/{token}', [ResetPasswordController::class, 'showResetPasswordView'])->name('password.reset');
    Route::post('reset-password', [ResetPasswordController::class, 'updatePassword'])->name('password.update');
});

Route::prefix('almadina')->middleware(['auth:admin'])->group(function () {
    Route::get('edit-password', [AuthController::class, 'editPassword'])->name('password.edit');
    Route::put('update-password', [AuthController::class, 'updatePassword']);
});

Route::prefix('almadina')->middleware('auth:admin')->group(function(){
    Route::view('admin/home','admin.starter')->name('admin.home');
});

Route::prefix('almadina/admin')->middleware('auth:admin')->group(function(){
    // Route::view('home','admin.starter')->name('admin.home');
    Route::resource('admins',AdminController::class);
    Route::get('edit-admin', [AdminController::class, 'editAdmin'])->name('admin.edit-admin');
    Route::put('update-admin/{id}', [AdminController::class, 'updateAdmin'])->name('admin.update-admin');
    Route::resource('abouts',AboutController::class);
    Route::resource('tags',TagController::class);
    Route::resource('sliders',SliderController::class);
    Route::resource('settings',SettingController::class);
    Route::resource('news',NewsController::class);
    Route::resource('comments',CommentController::class);
    Route::resource('teamMembers',TeamMemberController::class);
    Route::resource('offers',OfferController::class);
    Route::resource('conditions',ConditionController::class);
    Route::resource('nutritionalValues',NutritionalValueController::class);
    Route::resource('products',ProductController::class);
    Route::resource('albums',AlbumController::class);
    Route::resource('album_Images',AlbumImageController::class);
    Route::resource('product_tags',ProductTagController::class);
    Route::resource('brands',BrandController::class);
    Route::resource('theysaids',TheysaidController::class);
    Route::resource('contacts',ControllersContactController::class);
});

Route::prefix('almadina/admin')->middleware(['auth:admin'])->group(function(){
    Route::get('logout' , [AuthController::class , 'logout'])->name('almadina.logout');
});

// ******************************** Site ********************************* //

Route::prefix('almadina')->group(function(){
    Route::get('home',[homePagController::class,'home'])->name('almadina.home');
    Route::get('about',[AboutSiteController::class,'about'])->name('almadina.about');
    Route::get('offers',[OfferSiteController::class,'offers'])->name('almadina.offer');
    Route::get('offer_details',[OfferSiteController::class,'offer_details'])->name('almadina.offer_details');
    Route::post('subscribe', [OfferSiteController::class,'offerSubscribe'])->name('almadina.subscribe');
    Route::get('albums',[AlbumSiteController::class,'albums'])->name('almadina.albums');
    Route::get('news',[NewsSiteController::class,'news'])->name('almadina.news');
    Route::get('news_details',[NewsSiteController::class,'news_details'])->name('almadina.news_details');
    Route::post('comment',[NewsSiteController::class,'add_comment'])->name('almadina.addComment');
    Route::get('contact_us',[ContactController::class,'contact'])->name('almadina.contact');
    Route::post('contact_us',[ContactController::class,'sendMessage'])->name('almadina.sendMessage');
    Route::get('products',[ProductSiteController::class,'allProduct'])->name('almadina.product');
    Route::get('filter-product', [ProductSiteController::class, 'filterProduct'])->name('filter-product');
    // showProduct
    Route::get('show-product', [ProductSiteController::class, 'showProduct'])->name('show-product');
});