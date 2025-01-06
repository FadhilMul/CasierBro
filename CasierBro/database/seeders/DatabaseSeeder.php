<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
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
