<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Currency::insert([
            [
                'name'          => 'Albanian Lek',
                'code'          => 'ALL',
                'symbol'        => 'L',
                'exchange_rate' => 1.0000,
                'is_default'    => true
            ],
            [
                'name'          => 'US Dollar',
                'code'          => 'USD',
                'symbol'        => '$',
                'exchange_rate' => 0.0096,
                'is_default'    => false
            ],
            [
                'name'          => 'Euro',
                'code'          => 'EUR',
                'symbol'        => '€',
                'exchange_rate' => 0.0090,
                'is_default'    => false
            ],
            [
                'name'          => 'British Pound',
                'code'          => 'GBP',
                'symbol'        => '£',
                'exchange_rate' => 0.0077,
                'is_default'    => false
            ]
        ]);
    }
}
