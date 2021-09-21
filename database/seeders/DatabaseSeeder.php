<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
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

        DB::table('roles')->insert([
            'name' => 'Admin',
            'display_name' => 'Admin',
            'description' => 'Admin User'
        ]);

        DB::table('roles')->insert([
            'name' => 'Penyelaras',
            'display_name' => 'Penyelaras',
            'description' => 'Penyelaras User'
        ]);

        DB::table('roles')->insert([
            'name' => 'Penyelia',
            'display_name' => 'Penyelia',
            'description' => 'Penyelia User'
        ]);

        DB::table('roles')->insert([
            'name' => 'Pengguna',
            'display_name' => 'Pengguna',
            'description' => 'Pengguna User'
        ]);

        DB::table('users')->insert([
            'name' => 'Admin',
            'nokp' => '111',
            'email' => 'admin@admin.com',
            'password' => Hash::make('123123123'),
        ]);

        DB::table('years')->insert([
            'year' => date('Y')
        ]);
    }
}
