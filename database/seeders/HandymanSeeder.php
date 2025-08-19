<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Handyman;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class HandymanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Handyman::factory()->create([
            'user_id' => User::factory([
                'name' => 'Test Handyman',
                'email' => 'handyman@handyman.com',
                'role' => User::HANDYMAN,
            ]),
        ]);
        Handyman::factory(20)->create();
    }
}
