<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductProperty;
use App\Models\Property;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductPropertyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        return [
            'property_id'=>Property::inRandomOrder()->first()->id,
            'name'=>$this->faker->sentence(1),
            'count'=>$this->faker->numberBetween(0,100),
            'price'=>$this->faker->numberBetween(0,500),
        ];
    }
}
