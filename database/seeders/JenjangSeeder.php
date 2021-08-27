<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenjangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public static function run()
    {
      $nama = [
      'Pemula', 
      'Siaga', 
      'Muda', 
      'Pratama', 
      'Madya', 
      'Dewasa', 
      'Utama'
    ];
      foreach ( $nama as $na) {
        $jenjang[] = [
            'nama' => $na
        ];
      }
        DB::table('jenjang')->truncate();
        DB::table('jenjang')->insert($jenjang);
    }
}
