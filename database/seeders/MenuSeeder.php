<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('menus')->insert([
            [
                'name' => 'McChicken',
                'description' => 'Crispy chicken burger',
                'base_price' => 5.99,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'McBeef',
                'description' => '100% beef burger',
                'base_price' => 6.99,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'McVeggie',
                'description' => 'Vegetarian burger',
                'base_price' => 7.49,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
