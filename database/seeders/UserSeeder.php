<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'user@handyman.com',
        ]);
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@handyman.com',
            'role' => User::ADMIN
        ]);
        User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin@handyman.com',
            'role' => User::SUPER_ADMIN
        ]);
    }
}
