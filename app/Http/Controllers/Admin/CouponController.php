<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CouponRequest;
use App\Models\Product;
use App\Models\User;
use Coupon\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny',User::class);
        $coupons = $this->search($request, Coupon::all());
        $coupons = paginate($request, $coupons, config('app.paginate'));
        return view('admin.coupon.index',compact('coupons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create',User::class);
        $products = Product::where('status','activated')->get();
        return view('admin.coupon.create',compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CouponRequest $request)
    {
        $this->authorize('create',User::class);
        $code = Coupon::generateCode(8,true,true,false);
        try{
            Coupon::store($request->product_ids, 'product',$code,$request->discount,$request->limit_user,$request->expire_at);
            return responseMessage(true, 'create');
        }catch (\Exception $e){
            return responseMessage(false, 'create');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('create',User::class);
        $products = Product::where('status','activated')->get();
        list($coupon, $couponProducts) = array_values(Coupon::show($id));
        return view('admin.coupon.update',compact('coupon','couponProducts','products'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CouponRequest $request, $id)
    {
        $this->authorize('create',User::class);
        try{
            $coupon = Coupon::getCouponbyId($id);
            Coupon::update($id,$request->product_ids, 'product',$coupon['code'],$request->discount,$request->limit_user,$request->expire_at);
            return responseMessage(true, 'update');
        }catch (\Exception $e){
            return responseMessage(false, 'update');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('create',User::class);
        try{
            Coupon::delete($id);
            return responseMessage(true, 'delete');
        }catch (\Exception $e){
            return responseMessage(false, 'delete');
        }
    }

    /**
     * @param Request $request
     * @param $coupons
     * @return array|mixed
     */
    public function search(Request $request, $coupons)
    {
        $search = $request->search;
        if ($search != '') {
            $coupons = array_filter($coupons, function ($item) use ($search) {
                if ($item['code'] == $search)
                    return $item;
                if ($item['percent'] == str_replace('%', '', $search))
                    return $item;
                if (explode(' ', $item['expire_at'])[0] == $search)
                    return $item;
            });
        }
        return $coupons;
    }
}
