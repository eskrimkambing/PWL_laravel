<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::query()->delete();

        // =========================
        // MENU PIZZA
        // =========================

        Product::create([
            'name' => 'Extra Chicken',
            'category' => 'Pizza',
            'price' => 55000,
            'portion' => 'Medium',
            'description' => 'Pizza dengan topping ayam yang lezat.',
        ]);

        Product::create([
            'name' => 'Cheese Volcano',
            'category' => 'Pizza',
            'price' => 68000,
            'portion' => 'Medium',
            'description' => 'Pizza dengan topping keju yang melimpah.',
        ]);

        Product::create([
            'name' => 'Ekstra Beef',
            'category' => 'Pizza',
            'price' => 75000,
            'portion' => 'Medium',
            'description' => 'Pizza dengan topping daging sapi.',
        ]);

        Product::create([
            'name' => 'Original Mozza',
            'category' => 'Pizza',
            'price' => 25000,
            'portion' => 'Mini',
            'description' => 'Pizza original dengan mozzarella.',
        ]);

        Product::create([
            'name' => 'Original Cheese Volcano',
            'category' => 'Pizza',
            'price' => 55000,
            'portion' => 'Medium',
            'description' => 'Pizza original dengan keju yang melimpah.',
        ]);

        Product::create([
            'name' => 'Long Pizza',
            'category' => 'Pizza',
            'price' => 88000,
            'portion' => 'Original',
            'description' => 'Pizza dengan bentuk panjang dan topping pilihan.',
        ]);


        // =========================
        // MENU CEMILAN
        // =========================

        Product::create([
            'name' => 'Tape Bakar Original',
            'category' => 'Cemilan',
            'price' => 12000,
            'portion' => 'Box Kecil',
            'description' => 'Tape bakar original dengan rasa manis dan lezat.',
        ]);

        Product::create([
            'name' => 'Singkong Keju',
            'category' => 'Cemilan',
            'price' => 12000,
            'portion' => 'Box Kecil',
            'description' => 'Singkong goreng dengan topping keju yang gurih.',
        ]);

        Product::create([
            'name' => 'Tape Bakar Topping Keju',
            'category' => 'Cemilan',
            'price' => 12000,
            'portion' => 'Box Kecil',
            'description' => 'Tape bakar dengan topping keju yang lezat.',
        ]);
    }
}