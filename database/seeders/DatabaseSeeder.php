<?php

namespace Database\Seeders;

use App\Auxiliary\Uploader\Upload;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Guarantee;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductProperty;
use App\Models\ProductSpecification;
use App\Models\Property;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        Schema::disableForeignKeyConstraints();
        $this->truncate();
//         \App\Models\User::factory(20)->create();
         \App\Models\Category::factory(20)->create();
         \App\Models\Brand::factory(10)->create();
         \App\Models\Guarantee::factory(4)->create();
         \App\Models\Property::factory(2)->create();
         \App\Models\Product::factory(1000)->create();
         for ($i=1; $i<=1000;$i++){
             \App\Models\ProductImage::factory(1)->create(['product_id'=>$i]);
             \App\Models\ProductProperty::factory(1)->create(['product_id'=>$i]);
             \App\Models\ProductSpecification::factory(1)->create(['product_id'=>$i]);
         }

        Schema::enableForeignKeyConstraints();

    }

    private function truncate(){
//        User::truncate();
        Category::truncate();
        Brand::truncate();
        Guarantee::truncate();
        Property::truncate();
        Product::truncate();
        ProductProperty::truncate();
        ProductSpecification::truncate();
        ProductImage::truncate();
    }

}
