<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product; // Pastikan namespace Product benar

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Product::create([
            'name' => 'Dimsum Ayam',
            'description' => 'Dimsum ayam lezat dengan bumbu khas.',
            'price' => 20000,
            'image' => 'dimsum_ayam.jpg',
        ]);
        Product::create([
            'name' => 'Dimsum Udang',
            'description' => 'Dimsum udang segar dengan rasa gurih.',
            'price' => 25000,
            'image' => 'dimsum_udang.jpg',
        ]);
        Product::create([
            'name' => 'Dimsum Nori',
            'description' => 'Dimsum ayam dibungkus nori renyah.',
            'price' => 22000,
            'image' => 'dimsum_nori.jpg',
        ]);
        Product::create([
            'name' => 'Lumpia',
            'description' => 'Lumpia goreng crispy dengan isian ayam dan sayuran.',
            'price' => 15000,
            'image' => 'lumpia.jpg',
        ]);
    }
}
