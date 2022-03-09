<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tower;
class TowerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Tower::factory()->count(5)->create();
    }
}
