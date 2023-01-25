<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BrandFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->sentence(2);
        return [
            'user_id'=>User::where('access','vendor')->inRandomOrder()->first()->id,
            'brand_name'=>$name,
            'brand_logo'=>$this->faker->imageUrl,
            'brand_website'=>$this->faker->url,
            'status'=>'activated'
        ];
    }
}
