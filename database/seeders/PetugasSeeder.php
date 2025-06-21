<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Petugas;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class PetugasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure petugas role exists
        $petugasRole = Role::firstOrCreate(['name' => 'petugas']);

        // Create main petugas user
        $petugasUser = User::create([
            'name' => 'Petugas SIPMAS',
            'email' => 'petugas@sipmas.com',
            'password' => Hash::make('petugas123'),
            'phone' => '081234567890',
            'address' => 'Jl. Raya Manado - Tomohon, Tondano, Minahasa, Sulawesi Utara',
        ]);

        // Assign petugas role
        $petugasUser->assignRole($petugasRole);

        // Create petugas record
        Petugas::create([
            'user_id' => $petugasUser->id,
            'nrp' => '198501012010011001',
            'pangkat' => 'AIPTU',
            'nama' => 'Petugas SIPMAS',
            'unit_kerja' => 'Satuan Reskrim Polres Minahasa',
            'jabatan' => 'Kanit Reskrim',
            'no_hp' => '081234567890',
            'alamat' => 'Jl. Raya Manado - Tomohon, Tondano, Minahasa, Sulawesi Utara',
        ]);

        // Create additional test petugas
        $testPetugas = [
            [
                'name' => 'AIPTU Budi Santoso',
                'email' => 'petugas1@sipmas.com',
                'phone' => '081234567891',
                'address' => 'Jl. Raya Manado - Tomohon, Tondano',
                'nrp' => '198502022010011002',
                'pangkat' => 'AIPTU',
                'nama' => 'Budi Santoso',
                'unit_kerja' => 'Satuan Reskrim Polres Minahasa',
                'jabatan' => 'Kanit Reskrim',
                'no_hp' => '081234567891',
                'alamat' => 'Jl. Raya Manado - Tomohon, Tondano',
            ],
            [
                'name' => 'BRIPKA Siti Nurhaliza',
                'email' => 'petugas2@sipmas.com',
                'phone' => '081234567892',
                'address' => 'Jl. Raya Manado - Tomohon, Tondano',
                'nrp' => '198603032010011003',
                'pangkat' => 'BRIPKA',
                'nama' => 'Siti Nurhaliza',
                'unit_kerja' => 'Satuan Reskrim Polres Minahasa',
                'jabatan' => 'Kanit Reskrim',
                'no_hp' => '081234567892',
                'alamat' => 'Jl. Raya Manado - Tomohon, Tondano',
            ],
            [
                'name' => 'BRIGPOL Ahmad Rizki',
                'email' => 'petugas3@sipmas.com',
                'phone' => '081234567893',
                'address' => 'Jl. Raya Manado - Tomohon, Tondano',
                'nrp' => '198704042010011004',
                'pangkat' => 'BRIGPOL',
                'nama' => 'Ahmad Rizki',
                'unit_kerja' => 'Satuan Reskrim Polres Minahasa',
                'jabatan' => 'Kanit Reskrim',
                'no_hp' => '081234567893',
                'alamat' => 'Jl. Raya Manado - Tomohon, Tondano',
            ],
            [
                'name' => 'BRIGPOL Dewi Sartika',
                'email' => 'petugas4@sipmas.com',
                'phone' => '081234567894',
                'address' => 'Jl. Raya Manado - Tomohon, Tondano',
                'nrp' => '198805052010011005',
                'pangkat' => 'BRIGPOL',
                'nama' => 'Dewi Sartika',
                'unit_kerja' => 'Satuan Reskrim Polres Minahasa',
                'jabatan' => 'Kanit Reskrim',
                'no_hp' => '081234567894',
                'alamat' => 'Jl. Raya Manado - Tomohon, Tondano',
            ],
        ];

        foreach ($testPetugas as $petugasData) {
            $user = User::create([
                'name' => $petugasData['name'],
                'email' => $petugasData['email'],
                'password' => Hash::make('petugas123'),
                'phone' => $petugasData['phone'],
                'address' => $petugasData['address'],
            ]);

            $user->assignRole($petugasRole);

            Petugas::create([
                'user_id' => $user->id,
                'nrp' => $petugasData['nrp'],
                'pangkat' => $petugasData['pangkat'],
                'nama' => $petugasData['nama'],
                'unit_kerja' => $petugasData['unit_kerja'],
                'jabatan' => $petugasData['jabatan'],
                'no_hp' => $petugasData['no_hp'],
                'alamat' => $petugasData['alamat'],
            ]);
        }

        $this->command->info('Petugas users created successfully!');
        $this->command->info('Main petugas - Email: petugas@sipmas.com, Password: petugas123');
        $this->command->info('Additional test petugas created with same password: petugas123');
    }
} 