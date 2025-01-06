<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuItemsSeeder extends Seeder
{
    public function run()
    {
        DB::table('menu_items')->insert([
            ['name' => 'Nasi Goreng', 'price' => 15000, 'category' => 'foods'],
            ['name' => 'Teh Manis', 'price' => 5000, 'category' => 'drinks'],
            ['name' => 'Keripik Kentang', 'price' => 10000, 'category' => 'snacks'],
        ]);
    }
}
