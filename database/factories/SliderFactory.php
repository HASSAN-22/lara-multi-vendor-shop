<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SliderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $image = [
            'https://www.linkpicture.com/q/carousel-1.jpg',
            'https://www.linkpicture.com/q/carousel-2.jpg'
        ];
        return [
            'title'=>$this->faker->sentence(1),
            'link'=>'#',
            'image'=>$image[random_int(0,count($image)-1)]
        ];
    }
}
