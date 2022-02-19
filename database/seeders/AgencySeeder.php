<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AgencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('agency_hierarchy')->insert([
            'name' => 'JABATAN KERJA RAYA MALAYSIA',
            'flag' => 1,
            'delete_id' => 0
        ]);
    }
}
