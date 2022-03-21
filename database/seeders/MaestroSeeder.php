<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
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
    // Maestro::factory()->count(2)->create();
        DB::table('maestros')->insert([
            'name'=>'Small network',
            'url'=>'https://172.20.19.21/api/v2',
        ]);
    }
}
