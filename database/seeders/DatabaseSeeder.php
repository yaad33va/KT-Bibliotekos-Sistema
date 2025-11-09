<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**

    Seed the application's database.*/
    public function run(): void{$this->call(RolePermissionSeeder::class);

        $user = User::factory()->create([
            'name' => 'Test user',
            'email' => 'user@library.com',
            'password' => bcrypt('password'), // password
        ]);

        $user->assignRole('user');

        $admin = User::factory()->create([
            'name' => 'Admin user',
            'email' => 'admin@library.com',
            'password' => bcrypt('password'), // password
        ]);

        $admin->assignRole('admin');

        $librarian = User::factory()->create([
            'name' => 'Librarian user',
            'email' => 'librarian@library.com',
            'password' => bcrypt('password'), // password
        ]);

        $librarian->assignRole('librarian');
    }
}
