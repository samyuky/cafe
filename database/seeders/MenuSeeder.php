<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $menus = [
            ['name' => 'Kopi Latte', 'category' => 'minuman', 'price' => 25000, 'description' => 'Kopi dengan susu segar'],
            ['name' => 'Cappuccino', 'category' => 'minuman', 'price' => 28000, 'description' => 'Kopi dengan foam susu'],
            ['name' => 'Teh Tarik', 'category' => 'minuman', 'price' => 15000, 'description' => 'Teh susu khas'],
            ['name' => 'Nasi Goreng', 'category' => 'makanan', 'price' => 30000, 'description' => 'Nasi goreng spesial'],
            ['name' => 'Mie Goreng', 'category' => 'makanan', 'price' => 25000, 'description' => 'Mie goreng komplit'],
            ['name' => 'Roti Bakar', 'category' => 'makanan', 'price' => 20000, 'description' => 'Roti bakar coklat keju'],
        ];
        
        foreach($menus as $menu) {
            Menu::create($menu);
        }
    }
}
