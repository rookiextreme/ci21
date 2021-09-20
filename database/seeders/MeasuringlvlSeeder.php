<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MeasuringlvlSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('measuring_lvls')->insert([
            'name' => 'Corporate Effectiveness',
            'flag' => 1,
            'delete_id' => 0
        ]);

        DB::table('measuring_lvls')->insert([
            'name' => 'Leadership Effectiveness',
            'flag' => 1,
            'delete_id' => 0
        ]);

        DB::table('measuring_lvls')->insert([
            'name' => 'Personal Effectiveness',
            'flag' => 1,
            'delete_id' => 0
        ]);

        DB::table('measuring_lvls')->insert([
            'name' => 'Technical Mastery',
            'flag' => 1,
            'delete_id' => 0
        ]);

        DB::table('measuring_lvls')->insert([
            'name' => 'Keberkesanan Korporat',
            'flag' => 1,
            'delete_id' => 0
        ]);

        DB::table('measuring_lvls')->insert([
            'name' => 'Keberkesanan Kepimpinan',
            'flag' => 1,
            'delete_id' => 0
        ]);

        DB::table('measuring_lvls')->insert([
            'name' => 'Keberkesanan Sahsiah',
            'flag' => 1,
            'delete_id' => 0
        ]);

        DB::table('measuring_lvls')->insert([
            'name' => 'Kepakaran Teknikal',
            'flag' => 1,
            'delete_id' => 0
        ]);
    }
}
