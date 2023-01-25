<?php

namespace App\Auxiliary\Traits;

use App\Auxiliary\Uploader\Upload;
use App\Http\Requests\ProductRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Guarantee;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductProperty;
use App\Models\ProductSpecification;
use App\Models\Property;
use App\Models\User;
use Illuminate\Support\Facades\DB;

trait ProductTrait
{
    private function updateAndCreateProduct(ProductRequest $request, Product $product, bool $isUpdate=false){
        DB::beginTransaction();

        try{
            $this->insertProduct($request, $product);

            $this->insertProperties($request, $product,$isUpdate);

            $this->insertSpecifications($request, $product,$isUpdate);

            $this->insertImages($request, $product);

            DB::commit();
            return responseMessage(true, $isUpdate ? 'update' : 'create');

        }catch (\Exception $e){
            DB::rollBack();
            return responseMessage(false, $isUpdate ? 'update' : 'create');
        }
    }

    /**
     * @param $request
     * @param $product
     * @param $isUpdate
     * @return void
     */
    private function insertProperties($request, $product,$isUpdate=false): void
    {
        if($isUpdate){
            $product->productProperties()->delete();
        }
        if (!empty($request->property_ids)) {
            $data = [];
            foreach ($request->property_ids as $key => $id) {
                $data[] = [
                    'product_id' => $product->id,
                    'property_id' => $id,
                    'name' => $request->property_names[$key],
                    'count' => $request->property_counts[$key],
                    'price' => $request->property_prices[$key],
                ];
            }
            ProductProperty::insert($data);
        }
    }

    /**
     * @param $request
     * @param $product
     * @param $isUpdate
     * @return void
     */
    private function insertSpecifications($request, $product,$isUpdate=false): void
    {
        if($isUpdate){
            $product->productSpecifications()->delete();
        }
        if (!empty($request->specification_names)) {
            $data = [];
            foreach ($request->specification_names as $key => $name) {
                $data[] = [
                    'product_id' => $product->id,
                    'name' => $name,
                    'description' => $request->specification_descriptions[$key],
                ];
            }
            ProductSpecification::insert($data);
        }
    }

    /**
     * @param $request
     * @param $product
     * @return void
     */
    private function insertImages($request, $product): void
    {
        if (!empty($request->images)) {
            $data = [];
            foreach ($request->images as $key => $image) {
                $data[] = [
                    'product_id' => $product->id,
                    'image' => Upload::upload($request, 'images', $this->DIRECTORY, '', $key),
                ];
            }
            ProductImage::insert($data);
        }
    }

    /**
     * @param $request
     * @param Product $product
     * @return Product
     */
    private function insertProduct($request, Product $product): Product
    {
        $user =auth()->user();
        $product->user_id = $user->isAdmin() ? $request->user_id : $user->id;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;
        $product->guarantee_id = $request->guarantee_id;
        $product->title = $request->title;
        $product->price = $request->price;
        $product->discount = $request->discount;
        $product->count = $request->count;
        $product->short_description = $request->short_description;
        $product->description = $request->description;
        $product->meta_keyword = $request->meta_keyword;
        $product->meta_description = $request->meta_description;
        $product->status = $request->status;
        $product->is_original = $request->is_original;
        $product->save();
        return $product;
    }

    /**
     * @return array
     */
    public function productAdditionalData(): array
    {
        $brands = Brand::get();
        $categories = Category::get();
        $guarantees = Guarantee::get();
        $users = User::where('access', '!=', 'customer')->get();
        $properties = Property::get();
        return array($brands, $categories, $guarantees, $users, $properties);
    }
}
