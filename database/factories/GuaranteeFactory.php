<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class GuaranteeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $guarantee = ['guarantee 1','guarantee 2','guarantee 3','guarantee 4'];
        return [
            'guarantee'=> $guarantee[array_rand($guarantee)]
        ];
    }
}
