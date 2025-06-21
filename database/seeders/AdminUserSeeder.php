<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Petugas;
use Spatie\Permission\Models\Role;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@sipmas.com',
            'password' => bcrypt('admin123'),
        ]);

        // Create petugas data for admin
        $admin->petugas()->create([
            'nrp' => '198501011990031001',
            'pangkat' => 'Kompol',
            'nama' => 'Administrator',
            'jabatan' => 'Kapolres Minahasa',
            'unit_kerja' => 'Polres Minahasa',
            'no_hp' => '081234567890',
            'alamat' => 'Jl. Raya Manado - Tomohon, Tondano, Minahasa, Sulawesi Utara',
        ]);

        // Assign admin role to the user
        $adminRole = Role::where('name', 'admin')->first();
        $admin->assignRole($adminRole);

        $this->command->info('Admin user created successfully!');
        $this->command->info('Email: admin@sipmas.com');
        $this->command->info('Password: admin123');
        $this->command->info('NRP: 198501011990031001');
    }
}
