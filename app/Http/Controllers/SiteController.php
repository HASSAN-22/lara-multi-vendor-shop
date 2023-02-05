<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Slider;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function index(){
        $sliders = Slider::get();
        $query = Product::whereRelation('user','status','activated')->where('status','activated')->with(['image']);
        $products = clone($query)->inRandomOrder()->limit(8)->get();
        $justArriveds = clone($query)->latest()->limit(8)->get();
        $brands = Brand::where('status','activated')->get();
        return view('index',compact('sliders','products','justArriveds','brands'));
    }

    public function product(Product $product){
        dd($product);
    }

    public function addWishlist(Product $product){
        
    }
}
