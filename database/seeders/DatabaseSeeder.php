<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Currency;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $currencies = [
            [
                'country_name' => 'Singapore',
                'code' => 'SGD',
                'rate' => 16200,
            ],
            [
                'country_name' => 'Australian',
                'code' => 'AUS',
                'rate' => 16300,
            ],
        ];

        // Insert data into database
        foreach ($currencies as $currency) {
            Currency::create($currency);
        }
    }
}
