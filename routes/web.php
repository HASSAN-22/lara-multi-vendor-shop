<?php

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
    return view('index');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


// ############################################ Admin Routes ##########################################

Route::group(['middleware'=>'auth', 'prefix'=>'admin','as'=>'admin.'],function(){
    Route::resource('category',\App\Http\Controllers\Admin\CategoryController::class);
    Route::resource('brand',\App\Http\Controllers\Admin\BrandController::class);
    Route::resource('guarantee',\App\Http\Controllers\Admin\GuaranteeController::class);
    Route::resource('property',\App\Http\Controllers\Admin\PropertyController::class);
    Route::resource('user',\App\Http\Controllers\Admin\UserController::class);
    Route::resource('product',\App\Http\Controllers\Admin\ProductController::class);
    Route::post('deleteImage/{productImage}',[\App\Http\Controllers\Admin\ProductController::class,'deleteImage'])->name('product.deleteImage');
});

// ############################################ Vendor Routes ##########################################

Route::group(['middleware'=>'auth', 'prefix'=>'admin','as'=>'vendor.'],function(){
    Route::resource('product',\App\Http\Controllers\vendor\ProductController::class);
    Route::post('deleteImage/{productImage}',[\App\Http\Controllers\vendor\ProductController::class,'deleteImage'])->name('product.deleteImage');
});

// ############################################ All Routes ##########################################

Route::group(['middleware'=>'auth'],function(){
    Route::controller(\App\Http\Controllers\ProfileController::class)->group(function(){
        Route::get('profile/{user}','edit')->name('profile.edit');
        Route::patch('profile/{user}','update')->name('profile.update');
        Route::get('password/{user}','passwordEdit')->name('password.edit');
        Route::patch('password/{user}','passwordUpdate')->name('password.update');
    });
});
