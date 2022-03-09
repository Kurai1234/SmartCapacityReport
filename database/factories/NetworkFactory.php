<?php

namespace Database\Factories;

use App\Models\Maestro;
use App\Models\Network;
use Illuminate\Database\Eloquent\Factories\Factory;

class NetworkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */

     protected $model = Network::class;
    public function definition()
    {
        return [
            //
            'name'=> $this->faker->name(),
            'maestro_id'=>Maestro::all()->random()->id,
        ];
    }
}
