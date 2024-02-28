<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // $this->call(UserSeeder::class);
        // $this->call(TagSeeder::class);
        // $this->call(CategorySeeder::class);
        // $this->call(HandymanSeeder::class);
        $this->call(EventSeeder::class);
        $this->call(QuoteSeeder::class);
        $this->call(ReviewSeeder::class);
        $this->call(SubscriptionTypeSeeder::class);
        $this->call(YardSaleSeeder::class);
        $this->call(ReportSeeder::class);
    }
}
