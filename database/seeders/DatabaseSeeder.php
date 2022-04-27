<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        // \App\Models\Maestro::factory(2)->create();
        $this->call([
            MaestroSeeder::class,
            RoleSeeder::class
        
        ]);
    }
}
