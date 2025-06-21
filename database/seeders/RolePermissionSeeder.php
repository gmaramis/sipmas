<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // Dashboard permissions
            'view dashboard',
            
            // Pengaduan permissions
            'view pengaduan',
            'create pengaduan',
            'edit pengaduan',
            'delete pengaduan',
            'manage pengaduan',
            
            // User management permissions
            'view users',
            'create users',
            'edit users',
            'delete users',
            'manage users',
            
            // Petugas management permissions
            'view petugas',
            'create petugas',
            'edit petugas',
            'delete petugas',
            'manage petugas',
            
            // Statistics permissions
            'view statistics',
            'export statistics',
            
            // Settings permissions
            'view settings',
            'edit settings',
            'manage settings',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions
        $admin = Role::create(['name' => 'admin']);
        $petugas = Role::create(['name' => 'petugas']);
        $user = Role::create(['name' => 'user']);

        // Admin gets all permissions
        $admin->givePermissionTo(Permission::all());

        // Petugas permissions
        $petugas->givePermissionTo([
            'view dashboard',
            'view pengaduan',
            'edit pengaduan',
            'manage pengaduan',
            'view statistics',
        ]);

        // User permissions
        $user->givePermissionTo([
            'view dashboard',
            'create pengaduan',
            'view pengaduan',
        ]);

        $this->command->info('Roles and permissions seeded successfully!');
        $this->command->info('Created roles: admin, petugas, user');
        $this->command->info('Created permissions: ' . count($permissions) . ' permissions');
    }
}
