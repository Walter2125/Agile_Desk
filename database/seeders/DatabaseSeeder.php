<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

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
    public function createAdmin(){
        $user = new User;
        $user->name = 'Administrador';
        $user->email = 'admin@example.com';
        $user->password = bcrypt('contra1234');
        $user->role = 'admin';

        $user->save();

    }
}
