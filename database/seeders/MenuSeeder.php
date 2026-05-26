<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;
use App\Models\Ingredient;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        

        // McBeef
        $beef = Menu::create([
            'name'       => 'McBeef',
            'description'=> 'Juicy beef burger with lettuce and tomato',
            'base_price' => 8.99,
            'image'      => 'mcbeef.png',
        ]);
        $beef->ingredients()->createMany([
            ['name' => 'Beef patty',    'is_extra' => false, 'extra_price' => 0,    'image' => 'meat.png'],
            ['name' => 'Lettuce',       'is_extra' => false, 'extra_price' => 0,    'image' => 'lettuce.png'],
            ['name' => 'Tomato',        'is_extra' => false, 'extra_price' => 0,    'image' => 'tomato.png'],
            ['name' => 'Extra cheese',  'is_extra' => true,  'extra_price' => 0.50, 'image' => 'cheese.png'],
            ['name' => 'Bacon',         'is_extra' => true,  'extra_price' => 0.75, 'image' => 'bacon.png'],
        ]);

        // McChicken
        $chicken = Menu::create([
            'name'       => 'McChicken',
            'description'=> 'Crispy chicken burger with mayo and pickles',
            'base_price' => 7.99,
            'image'      => 'mcchicken.png',
        ]);
        $chicken->ingredients()->createMany([
            ['name' => 'Chicken patty', 'is_extra' => false, 'extra_price' => 0,    'image' => 'meat.png'],
            ['name' => 'Mayo',          'is_extra' => false, 'extra_price' => 0,    'image' => 'mayo.png'],
            ['name' => 'Pickles',       'is_extra' => false, 'extra_price' => 0,    'image' => 'pickles.png'],
            ['name' => 'Extra cheese',  'is_extra' => true,  'extra_price' => 0.50, 'image' => 'cheese.png'],
            ['name' => 'Jalapeños',     'is_extra' => true,  'extra_price' => 0.40, 'image' => 'jalapeno.png'],
        ]);

        // McVeggie
        $veggie = Menu::create([
            'name'       => 'McVeggie',
            'description'=> 'Fresh veggie burger with avocado and sprouts',
            'base_price' => 6.99,
            'image'      => 'mcveggie.png',
        ]);
        $veggie->ingredients()->createMany([
            ['name' => 'Veggie patty',  'is_extra' => false, 'extra_price' => 0,    'image' => 'meat.png'],
            ['name' => 'Avocado',       'is_extra' => false, 'extra_price' => 0,    'image' => 'avocado.png'],
            ['name' => 'Sprouts',       'is_extra' => false, 'extra_price' => 0,    'image' => 'sprouts.png'],
            ['name' => 'Extra cheese',  'is_extra' => true,  'extra_price' => 0.50, 'image' => 'cheese.png'],
            ['name' => 'Grilled onion', 'is_extra' => true,  'extra_price' => 0.40, 'image' => 'grilledonions.png'],
        ]);
    }
}