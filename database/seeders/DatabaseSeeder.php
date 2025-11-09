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
            'surname' => 'example',
            'email' => 'user@library.com',
            'password' => bcrypt('password'), // password
        ]);

        $user->assignRole('user');

        $admin = User::factory()->create([
            'name' => 'Admin user',
            'surname' => 'example',
            'email' => 'admin@library.com',
            'password' => bcrypt('password'), // password
        ]);

        $admin->assignRole('admin');

        $librarian = User::factory()->create([
            'name' => 'Librarian user',
            'surname' => 'example',
            'email' => 'librarian@library.com',
            'password' => bcrypt('password'), // password
        ]);

        $librarian->assignRole('librarian');
    }
}
