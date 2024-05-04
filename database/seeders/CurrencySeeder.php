<?php

use Illuminate\Database\Seeder;
use App\Models\Currency;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Array of currency data
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
