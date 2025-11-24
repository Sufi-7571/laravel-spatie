<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            'view products',
            'create products',
            'edit products',
            'delete products',
            'manage users',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create Admin Role
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());

        // Create User Role
        $userRole = Role::create(['name' => 'user']);
        $userRole->givePermissionTo(['view products', 'create products']);

        // Create Admin User
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
        ],
        [
            'name' => 'Admin Sufiyan',
            'email' => 'sufiyan@admin.com',
            'password' => Hash::make('password'),
        ]);
        $admin->assignRole('admin');

        // Create Normal User
        $user = User::create([
            'name' => 'Normal User',
            'email' => 'user@user.com',
            'password' => Hash::make('password'),
        ]);
        $user->assignRole('user');

        $this->command->info('✅ Admin created: admin@admin.com / password');
        $this->command->info('✅ User created: user@user.com / password');
    }
}
