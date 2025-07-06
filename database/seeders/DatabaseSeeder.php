<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        // First   Admin
        User::create([
            'name' => 'Diwas Sigdel',
            'email' => 'diwassigdel18@gmail.com',
            'password'=>bcrypt('prawash@187'),
            'role'=>'admin',
        ]);


         // Second Admin
        User::create([
            'name' => 'Pramisha Bhujel',
            'email' => 'pramishabhujel18@gmail.com',
            'password'=>bcrypt('prawash@1877    '),
            'role'=>'admin',
        ]);
    }
}
