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
        // Seed roles and permissions first
        $this->call(RolePermissionSeeder::class);

        // Create test users with different roles
        $admin = User::firstOrCreate(
            ['email' => 'admin@library.com'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );
        $admin->syncRoles(['administrator']);

        $librarian = User::firstOrCreate(
            ['email' => 'librarian@library.com'],
            [
                'name' => 'Librarian User',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );
        $librarian->syncRoles(['librarian']);

        $registered = User::firstOrCreate(
            ['email' => 'registered@library.com'],
            [
                'name' => 'Registered User',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );
        $registered->syncRoles(['registered']);

        // Original test user
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );
    }
}
