<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CouponRequest;
use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny',Coupon::class);
        $coupons = Coupon::latest()->search()->paginate(config('app.paginate'));
        return view('admin.coupon.index',compact('coupons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create',Coupon::class);
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
        $this->authorize('create',Coupon::class);
        DB::beginTransaction();
        try{
            $coupon = Coupon::create([
                'code'=>$request->code,
                'limit_user'=>$request->limit_user,
                'discount'=>$request->discount,
                'expire_at'=>$request->expire_at,
            ]);

            $coupon->belongsToManyCouponProducts()->attach($request->product_ids);
            DB::commit();
            return responseMessage(true, 'create');
        }catch (\Exception $e){
            DB::rollBack();
            dd($e->getMessage());
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
     * @param  Coupon $coupon
     * @return \Illuminate\Http\Response
     */
    public function edit(Coupon $coupon)
    {
        $this->authorize('update',$coupon);
        $products = Product::where('status','activated')->get();
        $coupon = $coupon->where('id',$coupon->id)->with('couponProducts')->first();
        $couponProducts = $coupon->couponProducts->pluck('id')->toArray();
        return view('admin.coupon.update',compact('coupon','couponProducts','products'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Coupon $coupon
     * @return \Illuminate\Http\Response
     */
    public function update(CouponRequest $request, Coupon $coupon)
    {
        $this->authorize('update',$coupon);
        DB::beginTransaction();
        try{
            $coupon->update([
                'code'=>$request->code,
                'limit_user'=>$request->limit_user,
                'discount'=>$request->discount,
                'expire_at'=>$request->expire_at,
            ]);

            $coupon->belongsToManyCouponProducts()->sync($request->product_ids);
            DB::commit();
            return responseMessage(true, 'create');
        }catch (\Exception $e){
            DB::rollBack();
            return responseMessage(false, 'create');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Coupon $coupon
     * @return \Illuminate\Http\Response
     */
    public function destroy(Coupon $coupon)
    {
        $this->authorize('delete',$coupon);
        try{
            $coupon->delete();
            return responseMessage(true, 'delete');
        }catch (\Exception $e){
            return responseMessage(false, 'delete');
        }
    }
}
