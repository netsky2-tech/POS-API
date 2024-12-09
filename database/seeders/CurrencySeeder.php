<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currencies = [
            [
                'code' => 'NIO',
                'name' => 'Córdoba',
                'symbol' => 'C$'
            ],
            [
                'code' => 'USD',
                'name' => 'Dólar',
                'symbol' => '$'
            ],
        ];
        foreach ($currencies as $currency) {
            Currency::create($currency);
        }
    }
}
