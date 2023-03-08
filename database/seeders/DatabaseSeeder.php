<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use LocationsSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            LokasiTableSeeder::class,
            RoleTableSeeder::class,
            UserTableSeeder::class,
            CategoryTableSeeder::class,
        ]);
    }
}
