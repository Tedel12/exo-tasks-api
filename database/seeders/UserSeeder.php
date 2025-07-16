<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
     public function run()
    {
        User::create([
            'id' => Str::uuid(),
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('12345678'), // Mot de passe haché
            'email_verified_at' => now(), 
        ]);

        
        User::create([
            'id' => Str::uuid(),
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('admin123'),
            'email_verified_at' => now(),]
        );

        User::factory(10)->create(); // pour créer 10 utilisateurs avec des données aléatoires

    }

}