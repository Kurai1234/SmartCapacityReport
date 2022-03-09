<?php

namespace Database\Seeders;

use App\Models\Maestro;
use Illuminate\Database\Seeder;

class MaestroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
    Maestro::factory()->count(2)->create();
    }
}
