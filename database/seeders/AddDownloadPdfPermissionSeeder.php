<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AddDownloadPdfPermissionSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Create the permission
        $permission = Permission::create(['name' => 'download product pdf']);

        // Assign to admin role
        $adminRole = Role::findByName('admin');
        $adminRole->givePermissionTo($permission);

        // Optionally assign to user role
        // $userRole = Role::findByName('user');
        // $userRole->givePermissionTo($permission);

        $this->command->info('Download PDF permission created and assigned successfully!');
    }
}