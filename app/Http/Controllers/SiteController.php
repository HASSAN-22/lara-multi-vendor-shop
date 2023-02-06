<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use App\Models\BasketProperty;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Slider;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SiteController extends Controller
{
    /**
     * Show data for index page
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(){
        $sliders = Slider::get();
        $query = Product::whereRelation('user','status','activated')->where('status','activated')->with(['image']);
        $products = (clone $query)->inRandomOrder()->limit(8)->get();
        $justArriveds = (clone $query)->latest()->get()->take(8);
        $brands = Brand::where('status','activated')->get();
        return view('index',compact('sliders','products','justArriveds','brands'));
    }

    /**
     * Show product detail
     * @param Product $product
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function product(Product $product){
        $product = $product->where('id',$product->id)->with([
            'guarantee',
            'brand',
            'productImages',
            'productProperties'=>fn($q)=>$q->with('property'),
            'productSpecifications',
        ])->first();
        $relateds = $product->category->products()->whereRelation('user','status','activated')->where('status','activated')->inRandomOrder()->with(['image'])->get()->take(4);
        return view('product',compact('product','relateds'));
    }

    /**
     * Add product to wishlist
     * @param Product $product
     * @return \Illuminate\Http\RedirectResponse|null
     */
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

    /**
     * Show products list
     * @param Category $category
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function category(Category $category){
        $products = $category->products()->where('status','activated')
            ->whereRelation('user','status','activated')    ->paginate(20);
        return view('category',compact('products','category'));
    }

    /**
     * Add product to basket
     * @param Request $request
     * @param Product $product
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function addBasket(Request $request, Product $product){
        $user = auth()->user();
        if(!$user){
            return response(['status'=>'error','error'=>'userLogin'],500);
        }
        if($product->count == 0){
            return response(['status'=>'error','error'=>'productCount'],500);
        }
        $basketCount = $user->baskets()->where('product_id',$product->id)->count();
        if($product->count < ($basketCount + $request->count)){
            return response(['status'=>'error','error'=>'The maximum number of product selections has been reached'],500);
        }
        DB::beginTransaction();
        try{
            $basket = Basket::firstOrNew(['user_id'=>$user->id,'product_id'=>$product->id]);
            $basket->count += $request->count;
            $basket->save();
            if($basket->basketProperties->count() <= 0){
                $properties = [];
                foreach($request->properties as $property){
                    $properties[] = [
                        'basket_id'=>$basket->id,
                        'property_id'=>$property
                    ];
                }
                BasketProperty::insert($properties);
            }
            DB::commit();
            return response(['status'=>'success']);
        }catch (\Exception $e){
            DB::rollBack();
            return response(['status'=>'error','error'=>$e->getMessage()],500);
        }
    }
}
