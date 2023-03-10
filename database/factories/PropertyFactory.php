<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PropertyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $properties = ['color','size'];
        return [
            'property'=> $properties[array_rand($properties)]
        ];
    }
}
