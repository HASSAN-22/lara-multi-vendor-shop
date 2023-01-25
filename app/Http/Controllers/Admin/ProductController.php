<?php

namespace App\Http\Controllers\Admin;

use App\Auxiliary\Traits\ProductTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use ProductTrait;

    private $DIRECTORY = 'uploader/product/images';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny',Product::class);
        $products = Product::latest()->with(['user'=>fn($q)=>$q->select('id','name'),'image','category'=>fn($q)=>$q->select('id','title')])->search()->paginate(config('app.paginate'));
        return view('admin.product.index',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create',Product::class);
        list($brands, $categories, $guarantees, $users, $properties) = $this->productAdditionalData();
        return view('admin.product.create',compact('brands','guarantees','categories','users','properties'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ProductRequest $request)
    {
        $this->authorize('create',Product::class);
        $product = new Product();
        return $this->updateAndCreateProduct($request, $product);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $this->authorize('update',$product);
        list($brands, $categories, $guarantees, $users, $properties) = $this->productAdditionalData();
        $product = $product->where('id',$product->id)->with([
            'productImages',
            'productProperties',
            'productSpecifications',
        ])->first();
        return view('admin.product.update',compact('brands','guarantees','categories','users','properties','product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProductRequest $request, Product $product)
    {
        $this->authorize('update',$product);
        return $this->updateAndCreateProduct($request, $product, true);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $this->authorize('delete',$product);
        return responseMessage($product->delete(), 'delete');
    }


    public function deleteImage(ProductImage $productImage){
        $product = $productImage->product;
        $this->authorize('delete',$product);
        return $productImage->delete() ? response(['status'=>'success']) : response(['status'=>'error'],500);
    }




}
