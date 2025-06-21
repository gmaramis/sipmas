<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create regular user
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'user@sipmas.com',
            'password' => bcrypt('user123'),
        ]);

        // Assign user role to the user
        $userRole = Role::where('name', 'user')->first();
        if ($userRole) {
            $user->assignRole($userRole);
        }

        // Create additional test users
        $users = [
            [
                'name' => 'Jane Smith',
                'email' => 'jane@sipmas.com',
                'password' => bcrypt('user123'),
            ],
            [
                'name' => 'Bob Johnson',
                'email' => 'bob@sipmas.com',
                'password' => bcrypt('user123'),
            ],
            [
                'name' => 'Alice Brown',
                'email' => 'alice@sipmas.com',
                'password' => bcrypt('user123'),
            ],
        ];

        foreach ($users as $userData) {
            $newUser = User::create($userData);
            if ($userRole) {
                $newUser->assignRole($userRole);
            }
        }

        $this->command->info('Regular users created successfully!');
        $this->command->info('Main user - Email: user@sipmas.com, Password: user123');
        $this->command->info('Additional test users created with same password: user123');
    }
} 