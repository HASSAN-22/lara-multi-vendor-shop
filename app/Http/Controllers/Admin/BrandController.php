<?php

namespace App\Http\Controllers\Admin;

use App\Auxiliary\Uploader\Upload;
use App\Http\Controllers\Controller;
use App\Http\Requests\BrandRequest;
use App\Models\Brand;
use App\Models\User;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny',Brand::class);
        $brands = Brand::latest()->with('user')->search()->paginate(config('app.paginate'));
        return view('admin.brand.index',compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create',Brand::class);
        $users = User::get();
        return view('admin.brand.create',compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BrandRequest $request)
    {
        $this->authorize('create',Brand::class);
        $brand = new Brand();
        return responseMessage($this->updateAndCreate($request, $brand),'create');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function edit(Brand $brand)
    {
        $this->authorize('update',$brand);
        $users = User::get();
        return view('admin.brand.update',compact('users','brand'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(BrandRequest $request, Brand $brand)
    {
        $this->authorize('update',$brand);
        return responseMessage($this->updateAndCreate($request, $brand, true),'update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy(Brand $brand)
    {
        $this->authorize('delete',$brand);
        return responseMessage($brand->delete(),'delete');
    }

    public function updateAndCreate(BrandRequest $request, Brand $brand, bool $isUpdate=false){
        $brand->user_id = $request->user_id;
        $brand->brand_name = $request->brand_name;
        $brand->brand_logo = Upload::upload($request, 'brand_logo','uploader/brand',($isUpdate ? $brand->brand_logo : ''));
        $brand->brand_website = $request->brand_website;
        $brand->status = $request->status;
        return $brand->save();
    }
}
