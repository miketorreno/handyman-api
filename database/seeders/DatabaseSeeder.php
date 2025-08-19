<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(TagSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(ServiceSeeder::class);
        $this->call(SubscriptionTypeSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(HandymanSeeder::class);
        $this->call(EventSeeder::class);
        $this->call(QuoteSeeder::class);
        $this->call(ReviewSeeder::class);
        $this->call(YardSaleSeeder::class);
        $this->call(ReportSeeder::class);
        $this->call(PostSeeder::class);
    }
}
