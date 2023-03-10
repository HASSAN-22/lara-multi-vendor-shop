<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use App\Models\BasketProperty;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\CouponUser;
use App\Models\Order;
use App\Models\OrderUser;
use App\Models\Product;
use App\Models\Profile;
use App\Models\Rating;
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
            'user'=>fn($q)=>$q->select('id','name'),
            'brand',
            'ratings',
            'productImages',
            'productProperties'=>fn($q)=>$q->with('property'),
            'productSpecifications',
            'comments'=>fn($q)=>$q->with([
                'user'=>fn($q)=>$q->select('id','name')->with('ratings')
            ])
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
            return responseMessage('','manual','Added successfully');
        }
        return responseMessage('','manual','You need to login to the website');
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
            return response(['status'=>'error','error'=>'basketCount'],500);
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
                        'product_property_id'=>$property
                    ];
                }
                BasketProperty::insert($properties);
            }
            DB::commit();
            return response(['status'=>'success']);
        }catch (\Exception $e){
            DB::rollBack();
            return response(['status'=>'error','e'=>$e->getMessage()],500);
        }
    }



    /**
     * Update count of product in basket
     * @param Request $request
     * @param Product $product
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function updateBasketCount(Request  $request, Product  $product){
        $user = auth()->user();
        if(!$user){
            return response(['status'=>'error','error'=>'userLogin'],500);
        }
        if($product->count == 0){
            return response(['status'=>'error','error'=>'productCount'],500);
        }
        $basket= $user->baskets()->where('product_id',$product->id)->first();
        if($basket && $product->count < $request->count){
            return response(['status'=>'error','error'=>'basketCount'],500);
        }
        return $basket->update(['count'=>$request->count]) ? response(['status'=>'success']) : response(['status'=>'error'],500);
    }

    public function deleteBasket(Basket $basket){
        $this->authorize('delete',$basket);
        return $basket->delete() ? back()->with('manual','Delete successfully') : back()->with('manual','Server error');
    }

    /**
     * Insert comment and rating  for product
     * @param Request $request
     * @param Product $product
     * @return \Illuminate\Http\RedirectResponse|null
     */
    public function productComment(Request $request, Product $product){
        $user = auth()->user();
        if(!$user){
            return responseMessage('','manual','You need to login to the website');
        }
        $request->validate([
           'name'=>['required','string','max:255'],
           'email'=>['required','string','max:255'],
           'message'=>['required','string','max:1000'],
           'rating'=>['required','string','in:1,2,3,4,5']
        ]);

        DB::beginTransaction();
        try{
            $product->comments()->create([
               'user_id'=>$user->id,
               'name'=>$request->name,
               'email'=>$request->email,
               'message'=>$request->message
            ]);
            Rating::firstOrCreate(['product_id'=>$product->id,'user_id'=>$user->id],['rating'=>$request->rating]);
            return responseMessage('','manual','Your message has been added successfully');
        }catch (\Exception $e){
            DB::rollBack();
            return responseMessage('','manual','Server error');
        }
    }

    public function cart(){
        $user = auth()->user();
        if(!$user){
            return responseMessage('','manual','You need to login to the website');
        }
        $baskets = $user->baskets()->with(['product'=>fn($q)=>$q->select('id','title','price','discount')->with('image')])->get();
        $couponUser = $user->couponUsers()
            ->whereRelation('coupon',fn($q)=>$q->whereRelation('couponProducts',fn($q)=>$q->whereIn('product_id',$baskets->pluck('product_id')->toArray())))
            ->with('coupon')->first();
        $discount = $couponUser ? $couponUser->coupon->discount * $couponUser->count : 0;
        return view('cart',compact('baskets','discount'));
    }

    public function cartCoupon(Request $request){
        $user = auth()->user();
        if(!$user){
            return responseMessage('','manual','You need to login to the website');
        }
        $coupon = Coupon::where('code',$request->coupon)->first();

        $result = $this->countIsValid($request, $user);

        if(!is_null($result)){
            list($check, $count) = $this->incrementCouponCountForUser($user, $coupon);
            if($check){
                return back()->with('discount',$coupon->discount*$count);
            }
        }

        return responseMessage('','manual','Coupon is not valid or expire');
    }

    public function checkout(){
        $user = auth()->user();
        if(!$user){
            return responseMessage('','manual','You need to login to the website');
        }
        $baskets = $user->baskets()->with(['product'=>fn($q)=>$q->select('id','title','price','discount'),'basketProperties'])->get();
        $couponUser = $user->couponUsers()
            ->whereRelation('coupon',fn($q)=>$q->whereRelation('couponProducts',fn($q)=>$q->whereIn('product_id',$baskets->pluck('product_id')->toArray())))
            ->with('coupon')->first();
        $discount = $couponUser ? $couponUser->coupon->discount * $couponUser->count : 0;

        return view('checkout',compact('user','baskets','discount'));
    }

    public function order(Request $request){
        $user = auth()->user();
        if(!$user){
            return responseMessage('','manual','You need to login to the website');
        }
        $request->validate([
            'name'=>['required','string','max:255'],
            'email'=>['required','string','max:255','email','unique:users,id,email'],
            'address'=>['required','string','max:255'],
            'city'=>['required','string','max:255'],
            'province'=>['required','string','max:255'],
            'plak'=>['required','numeric','unique:profiles,plak'],
            'national_id'=>['required','numeric','unique:profiles,id,national_id'],
            'payment'=>['required','string','in:paypal,directcheck,banktransfer'],
        ]);

        DB::beginTransaction();
        try{
            $user->name = $request->name;
            $user->email = $request->email;
            $user->save();
            Profile::updateOrCreate(['user_id'=>$user->id],[
                'address'=>$request->address,
                'city'=>$request->city,
                'province'=>$request->province,
                'plak'=>$request->plak,
                'national_id'=>$request->national_id,
            ]);
            $baskets = $user->baskets()->with(['product'=>fn($q)=>$q->select('id','user_id','title','price','discount','count'),'basketProperties'])->get();
            $couponUser = $user->couponUsers()
                ->whereRelation('coupon',fn($q)=>$q->whereRelation('couponProducts',fn($q)=>$q->whereIn('product_id',$baskets->pluck('product_id')->toArray())))
                ->with('coupon')->first();
            $discount = $couponUser ? $couponUser->coupon->discount * $couponUser->count : 0;
            $order = Order::create([
                'user_id'=>$user->id,
                'status'=>'awaiting_payment',
                'discount'=>$discount,
                'coupon_code'=>$couponUser ? $couponUser->coupon->code : null
            ]);

            $orderUsers = [];
            foreach ($baskets as $key=>$basket) {
                $full_amount = 0;
                $product= $basket->product;
                if($product->count == 0){
                    return responseMessage('','manual','Some selected products are out of stock');
                }
                $properties = $basket->basketProperties()->with('productProperty')->get();
                $full_amount += $product->price;
                $propertyData = [];
                foreach ($properties as $property){
                    $productProperty = $property->productProperty;
                    $full_amount += $productProperty->price;
                    $propertyData[] = [
                        'name'=>$productProperty->name,
                        'price'=>$productProperty->price,
                    ];
                    $productProperty->count -= 1;
                    $productProperty->save();
                }
                 $orderUsers[] = [
                     'order_id'=>$order->id,
                     'user_id'=>$product->user_id,
                     'price'=>(double)$product->price,
                     'title'=>$product->title,
                     'count'=>$basket->count,
                     'product_discount'=>$product->discount,
                     'full_amount'=>$full_amount,
                     'property'=> json_encode($propertyData),
                     'created_at'=>now(),
                     'updated_at'=>now(),
                 ];

                $product->count -= $basket->count;
                $product->save();
            }
            $orderUser = OrderUser::insert($orderUsers);
            if($orderUser){
                $user->baskets()->delete();
            }
            DB::commit();
            return view('order_done');
        }catch (\Exception $e){
            DB::rollBack();
            return responseMessage('','manual','Server error');
        }
    }

    /**
     * @param Request $request
     * @param \Illuminate\Contracts\Auth\Authenticatable $user
     * @return mixed
     */
    private function countIsValid(Request $request, \Illuminate\Contracts\Auth\Authenticatable $user)
    {
        $basketProducts = $user->baskets->pluck('product_id')->toArray();
        return Coupon::where('expire_at', '>', now())->where('code', $request->coupon)
            ->where(fn($q)=>$q->whereRelation('couponProducts',fn($q)=>$q->whereIn('product_id', $basketProducts)))->first();
    }

    /**
     * @param \Illuminate\Contracts\Auth\Authenticatable $user
     * @param $coupon
     * @return array
     */
    private function incrementCouponCountForUser(\Illuminate\Contracts\Auth\Authenticatable $user, $coupon): array
    {
        $coupon_user = $user->couponUsers()->where('coupon_id', $coupon->id)->first();
        $couponUser = CouponUser::firstOrNew(['user_id' => $user->id, 'coupon_id' => $coupon->id]);
        $check = false;
        if (is_null($coupon_user) or ($coupon_user->status == 'no' and $coupon_user->count != $coupon->limit_user)) {
            $couponUser->status = 'no';
            $couponUser->count += 1;
            $check = true;
        } else {
            $couponUser->status = 'yes';
        }

        $couponUser->save();
        return [$check, $couponUser->count];
    }
}
