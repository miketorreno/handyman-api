<?php

namespace Database\Seeders;

use App\Models\YardSale;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class YardSaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        YardSale::factory(20)->create();
    }
}
