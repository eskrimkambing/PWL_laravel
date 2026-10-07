<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Hapus produk lama
        Product::query()->delete();

        // Tambahkan menu Pizza Moza
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
    }
}
