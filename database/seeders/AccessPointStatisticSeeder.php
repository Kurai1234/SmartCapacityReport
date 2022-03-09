<?php

namespace Database\Seeders;

use App\Models\AccessPointStatistic;
use Illuminate\Database\Seeder;

class AccessPointStatisticSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        AccessPointStatistic::factory()->count(5)->create();
    }
}
