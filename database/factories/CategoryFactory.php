<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->sentence(2);

        return [
            'parent_id'=>random_int(0,20),
            'title'=>rtrim($title, '.'),
            'slug'=>Str::slug(rtrim($title, '.')),
            'status'=>'activated',
            'meta_description'=>$this->faker->paragraph,
            'meta_keyword'=>$this->faker->paragraph,
        ];
    }
}
