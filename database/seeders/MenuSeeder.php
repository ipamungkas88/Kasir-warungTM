<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menus = [
            // Makanan
            ['name' => 'Nasi Gudeg', 'description' => 'Nasi gudeg khas Yogyakarta dengan ayam dan telur', 'price' => 15000, 'category' => 'Makanan', 'stock' => 25],
            ['name' => 'Nasi Pecel', 'description' => 'Nasi pecel dengan sayuran segar dan bumbu kacang', 'price' => 12000, 'category' => 'Makanan', 'stock' => 30],
            ['name' => 'Gado-gado', 'description' => 'Gado-gado dengan bumbu kacang dan kerupuk', 'price' => 13000, 'category' => 'Makanan', 'stock' => 20],
            ['name' => 'Mie Ayam', 'description' => 'Mie ayam dengan bakso dan pangsit', 'price' => 14000, 'category' => 'Makanan', 'stock' => 15],
            ['name' => 'Soto Ayam', 'description' => 'Soto ayam kuning dengan telur dan kerupuk', 'price' => 16000, 'category' => 'Makanan', 'stock' => 18],
            ['name' => 'Bakso', 'description' => 'Bakso sapi dengan mie dan sayuran', 'price' => 15000, 'category' => 'Makanan', 'stock' => 12],
            
            // Minuman
            ['name' => 'Es Teh Manis', 'description' => 'Es teh manis segar', 'price' => 5000, 'category' => 'Minuman', 'stock' => 50],
            ['name' => 'Es Jeruk', 'description' => 'Es jeruk segar asam manis', 'price' => 7000, 'category' => 'Minuman', 'stock' => 35],
            ['name' => 'Kopi Hitam', 'description' => 'Kopi hitam panas tradisional', 'price' => 6000, 'category' => 'Minuman', 'stock' => 40],
            ['name' => 'Teh Hangat', 'description' => 'Teh hangat manis', 'price' => 4000, 'category' => 'Minuman', 'stock' => 45],
            ['name' => 'Es Campur', 'description' => 'Es campur dengan berbagai topping', 'price' => 10000, 'category' => 'Minuman', 'stock' => 8],
            ['name' => 'Jus Alpukat', 'description' => 'Jus alpukat segar dengan susu', 'price' => 12000, 'category' => 'Minuman', 'stock' => 22],
            
            // Snack
            ['name' => 'Kerupuk', 'description' => 'Kerupuk renyah sebagai pelengkap', 'price' => 2000, 'category' => 'Snack', 'stock' => 60],
            ['name' => 'Tempe Goreng', 'description' => 'Tempe goreng renyah', 'price' => 3000, 'category' => 'Snack', 'stock' => 25],
            ['name' => 'Tahu Goreng', 'description' => 'Tahu goreng dengan bumbu', 'price' => 3000, 'category' => 'Snack', 'stock' => 30],
            ['name' => 'Pisang Goreng', 'description' => 'Pisang goreng renyah manis', 'price' => 8000, 'category' => 'Snack', 'stock' => 5],
        ];

        foreach ($menus as $menu) {
            Menu::create($menu);
        }
    }
}
