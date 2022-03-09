<?php

namespace Database\Factories;

use App\Models\Network;
use App\Models\Tower;
use Illuminate\Database\Eloquent\Factories\Factory;

class TowerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Tower::class;
    public function definition()
    {
        return [
            //
            'name'=>$this->faker->name(),
            'network_id'=>Network::all()->random()->id,
        ];
    }
}
