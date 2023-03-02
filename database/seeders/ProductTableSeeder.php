<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id' => 1,
                'nama_produk' => 'Bunga Mawar Merah',
                'deskripsi' => 'Bunga Mawar Merah',
                'harga' => 25000,
                'stok' => 30,
                'gambar' => '',
            ]
        ];
    }
}
