<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
      DB::table('currency_rates')->insert([
        'name' => 'MYR',
        'rate' => '1',
        'updated_at'=>now()
      ]);

      DB::table('currency_rates')->insert([
        'name' => 'USD',
        'rate' => '4.7',
        'updated_at'=>now()
      ]);

    }
}
