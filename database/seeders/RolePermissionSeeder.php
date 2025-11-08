<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions (edit this list for your app)
        $permissions = [
            'view books',
            'create books',
            'edit books',
            'delete books',
            'borrow books',
            'manage users',
            'view reports',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles and assign permissions (names MUST match DatabaseSeeder)
        $registered = Role::firstOrCreate(['name' => 'registered']);
        $registered->syncPermissions([
            'view books',
            'borrow books',
        ]);

        $librarian = Role::firstOrCreate(['name' => 'librarian']);
        $librarian->syncPermissions([
            'view books',
            'create books',
            'edit books',
            'delete books',
            'view reports',
        ]);

        $adminRole = Role::firstOrCreate(['name' => 'administrator']);
        // administrator gets all permissions
        $adminRole->syncPermissions(Permission::all());
    }
}
