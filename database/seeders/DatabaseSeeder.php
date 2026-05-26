<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Test user
        User::create([
            'name'     => 'user',
            'email'    => 'test@mcorder.com',
            'password' => Hash::make('user123'),
        ]);

        // Menús
        $this->call([
            MenuSeeder::class,
        ]);
    }
    
}
