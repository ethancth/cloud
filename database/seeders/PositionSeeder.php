<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

      DB::table('roles')->insert([
        'name' => 'Boss',
        'guard_name' => 'web',
        'created_at' => now(),
        'updated_at' => now(),

      ]);

      DB::table('roles')->insert([
        'name' => 'User',
        'guard_name' => 'web',
        'created_at' => now(),
        'updated_at' => now(),

      ]);
      DB::table('roles')->insert([
        'name' => 'Admin',
        'guard_name' => 'web',
        'created_at' => now(),
        'updated_at' => now(),

      ]);
    }
}
