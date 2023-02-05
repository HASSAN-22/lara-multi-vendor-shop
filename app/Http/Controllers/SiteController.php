<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Slider;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function index(){
        $sliders = Slider::get();
        $query = Product::whereRelation('user','status','activated')->where('status','activated')->with(['image']);
        $products = (clone $query)->inRandomOrder()->limit(8)->get();
        $justArriveds = (clone $query)->latest()->get()->take(8);
        $brands = Brand::where('status','activated')->get();
        return view('index',compact('sliders','products','justArriveds','brands'));
    }

    public function product(Product $product){
        dd($product);
    }

    public function addWishlist(Product $product){
        $user = auth()->user();
        if($user){
            Wishlist::updateOrCreate(
                ['user_id'=>$user->id,'product_id'=>$product->id],
                ['user_id'=>$user->id,'product_id'=>$product->id]
            );
            return responseMessage(true,'manual','Added successfully');
        }
        return responseMessage(true,'manual','You need to login to the website');
    }
}
