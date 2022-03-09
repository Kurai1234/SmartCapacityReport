<?php

namespace Database\Factories;

use App\Models\Maestro;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class MaestroFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */

     protected $model = Maestro::class;
    public function definition()
    {
        return [
            
            'name'=>$this->faker->name(),
            'url'=>$this->faker->name(),
        ];
    }
}
