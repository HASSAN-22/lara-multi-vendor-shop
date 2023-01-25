<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Guarantee;
use App\Models\Property;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "user_id"=>User::where('access','vendor')->inRandomOrder()->first()->id,
            "title" =>$this->faker->sentence(1),
            "category_id" =>Category::where('status','activated')->inRandomOrder()->first()->id,
            "brand_id" =>Brand::where('status','activated')->inRandomOrder()->first()->id,
            "guarantee_id" =>Guarantee::inRandomOrder()->first()->id,
            "price" =>$this->faker->numberBetween(0,2000),
            "discount" =>$this->faker->numberBetween(0,100),
            "count" =>$this->faker->numberBetween(),
            "is_original" =>'yes',
            "status" =>'activated',
            "short_description" =>$this->faker->paragraph(2),
            "description" =>$this->faker->paragraph(12),
            "meta_description" =>$this->faker->paragraph(2),
            "meta_keyword" =>$this->faker->paragraph(2),
        ];
    }
}
