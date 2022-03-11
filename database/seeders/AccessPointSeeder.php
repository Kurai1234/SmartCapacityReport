<?php

namespace Database\Seeders;

use App\Models\AccessPoint;
use Illuminate\Database\Seeder;

class AccessPointSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        AccessPoint::factory()->count(5)->create();

    }
}
