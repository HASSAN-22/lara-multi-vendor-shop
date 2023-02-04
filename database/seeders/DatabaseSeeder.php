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
use App\Models\Slider;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

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
        $this->addCategory();


         \App\Models\Brand::factory(10)->create();
         \App\Models\Guarantee::factory(4)->create();
         \App\Models\Property::factory(2)->create();
         \App\Models\Product::factory(1000)->create();
         for ($i=1; $i<=1000;$i++){
             \App\Models\ProductImage::factory(1)->create(['product_id'=>$i]);
             \App\Models\ProductProperty::factory(1)->create(['product_id'=>$i]);
             \App\Models\ProductSpecification::factory(1)->create(['product_id'=>$i]);
         }
        \App\Models\Slider::factory(2)->create();

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
        Slider::truncate();
    }

    private function addCategory(){
        $data = [
            [
                'parent_id'=>0,
                'title'=>'Woman',
                'slug'=>Str::slug(rtrim('Woman', '.')),
                'status'=>'activated',
                'meta_description'=>'meta description',
                'meta_keyword'=>'meta keywoard',
            ],

            [
                'parent_id'=>1,
                'title'=>'Shoes',
                'slug'=>Str::slug(rtrim('Shoes', '.')),
                'status'=>'activated',
                'meta_description'=>'meta description',
                'meta_keyword'=>'meta keywoard',
            ],
            [
                'parent_id'=>1,
                'title'=>'Clothing',
                'slug'=>Str::slug(rtrim('Clothing', '.')),
                'status'=>'activated',
                'meta_description'=>'meta description',
                'meta_keyword'=>'meta keywoard',
            ],
            [
                'parent_id'=>2,
                'title'=>'Boots',
                'slug'=>Str::slug(rtrim('Boots', '.')),
                'status'=>'activated',
                'meta_description'=>'meta description',
                'meta_keyword'=>'meta keywoard',
            ],
            [
                'parent_id'=>3,
                'title'=>'Dresses',
                'slug'=>Str::slug(rtrim('Dresses', '.')),
                'status'=>'activated',
                'meta_description'=>'meta description',
                'meta_keyword'=>'meta keywoard',
            ],

            //////////////////////
            [
                'parent_id'=>0,
                'title'=>'Men',
                'slug'=>Str::slug(rtrim('Men', '.')),
                'status'=>'activated',
                'meta_description'=>'meta description',
                'meta_keyword'=>'meta keywoard',
            ],
            [
                'parent_id'=>6,
                'title'=>'Shoes',
                'slug'=>Str::slug(rtrim('Shoes', '.')),
                'status'=>'activated',
                'meta_description'=>'meta description',
                'meta_keyword'=>'meta keywoard',
            ],
            [
                'parent_id'=>6,
                'title'=>'Clothing',
                'slug'=>Str::slug(rtrim('Clothing', '.')),
                'status'=>'activated',
                'meta_description'=>'meta description',
                'meta_keyword'=>'meta keywoard',
            ],
            [
                'parent_id'=>7,
                'title'=>'Boots',
                'slug'=>Str::slug(rtrim('Boots', '.')),
                'status'=>'activated',
                'meta_description'=>'meta description',
                'meta_keyword'=>'meta keywoard',
            ],
            [
                'parent_id'=>8,
                'title'=>'Dresses',
                'slug'=>Str::slug(rtrim('Dresses', '.')),
                'status'=>'activated',
                'meta_description'=>'meta description',
                'meta_keyword'=>'meta keywoard',
            ],
        ];
        \App\Models\Category::insert($data);
    }

}
