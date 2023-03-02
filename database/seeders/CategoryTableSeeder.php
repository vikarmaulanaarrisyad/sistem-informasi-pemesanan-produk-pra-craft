<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id' => 1,
                'nama_kategori' => 'Angger',
                'slug' => 'anggrek'
            ],
            [
                'id' => 2,
                'nama_kategori' => 'Mawar',
                'slug' => 'mawar'
            ],
            [
                'id' => 3,
                'nama_kategori' => 'Melati',
                'slug' => 'melati'
            ]
        ];

        foreach ($data as  $value) {
            Category::create($value);
        }
    }
}
