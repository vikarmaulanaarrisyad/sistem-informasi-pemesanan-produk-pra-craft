<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::factory(10)->create();

        // mendapatkan user pertama dan merubahnya
        $user = User::first();
        $user->name = 'Administrator';
        $user->email = 'admin@gmail.com';
        $user->password = Hash::make('123456');
        $user->role_id = 1;
        $user->save();
    }
}
