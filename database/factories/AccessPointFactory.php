<?php

namespace Database\Factories;

use App\Models\AccessPoint;
use App\Models\Tower;
use Illuminate\Database\Eloquent\Factories\Factory;

class AccessPointFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = AccessPoint::class;
    public function definition()
    {
        return [
            //
            'name'=>$this->faker->name(),
            'mac_address'=>$this->faker->name(),
            'product'=>$this->faker->name(),
            'tower_id'=>Tower::all()->random()->id,
            'type'=>$this->faker->name(),
        ];
    }
}
