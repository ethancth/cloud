<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Opf;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {


        \App\Models\User::factory()->create([
            'name' => 'admin',
            'email' => 'opfs.gs@gmail.com',
          'password' => bcrypt('opfs.gs@gmail.com'),
        ]);

      DB::table('opfs')->insert([
        'id'=>'0',
        'created_by' => '0'
      ]);
      $opf=Opf::find(1);
      $opf->id=0;
      $opf->save();

      $this->call(CurrencySeeder::class);
      $this->call(PositionSeeder::class);


      $path = 'database/backup/opf_item_supplier.sql';
      DB::unprepared(file_get_contents($path));
      $this->command->info('OPF Item Supplier seeded!');

    }
}
