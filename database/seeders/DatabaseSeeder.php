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
        DB::table('dict_bank_measuring_lvls')->insert([
            [
                'name' => 'Corporate Effectiveness',
                'flag' => 1,
                'delete_id' => 0
            ],
            [
                'name' => 'Leadership Effectiveness',
                'flag' => 1,
                'delete_id' => 0
            ],
            [
                'name' => 'Personal Effectiveness',
                'flag' => 1,
                'delete_id' => 0
            ],
            [
                'name' => 'Technical Mastery',
                'flag' => 1,
                'delete_id' => 0
            ],
            [
                'name' => 'Keberkesanan Korporat',
                'flag' => 1,
                'delete_id' => 0
            ],
            [
                'name' => 'Keberkesanan Kepimpinan',
                'flag' => 1,
                'delete_id' => 0
            ],
            [
                'name' => 'Keberkesanan Sahsiah',
                'flag' => 1,
                'delete_id' => 0
            ],
            [
                'name' => 'Kepakaran Teknikal',
                'flag' => 1,
                'delete_id' => 0
            ]
        ]);

        DB::table('dict_col_measuring_lvls')->insert([
            [
                'name' => 'Corporate Effectiveness',
                'flag' => 1,
                'delete_id' => 0
            ],
            [
                'name' => 'Leadership Effectiveness',
                'flag' => 1,
                'delete_id' => 0
            ],
            [
                'name' => 'Personal Effectiveness',
                'flag' => 1,
                'delete_id' => 0
            ],
            [
                'name' => 'Technical Mastery',
                'flag' => 1,
                'delete_id' => 0
            ],
            [
                'name' => 'Keberkesanan Korporat',
                'flag' => 1,
                'delete_id' => 0
            ],
            [
                'name' => 'Keberkesanan Kepimpinan',
                'flag' => 1,
                'delete_id' => 0
            ],
            [
                'name' => 'Keberkesanan Sahsiah',
                'flag' => 1,
                'delete_id' => 0
            ],
            [
                'name' => 'Kepakaran Teknikal',
                'flag' => 1,
                'delete_id' => 0
            ]
        ]);

        DB::table('roles')->insert([
            [
                'name' => 'Admin',
                'display_name' => 'Admin',
                'description' => 'Admin User'
            ],
            [
                'name' => 'Penyelaras',
                'display_name' => 'Penyelaras',
                'description' => 'Penyelaras User'
            ],
            [
                'name' => 'Penyelia',
                'display_name' => 'Penyelia',
                'description' => 'Penyelia User'
            ],
            [
                'name' => 'Pengguna',
                'display_name' => 'Pengguna',
                'description' => 'Pengguna User'
            ]
        ]);

        DB::table('users')->insert([
            'name' => 'Admin',
            'nokp' => '111',
            'email' => 'admin@admin.com',
            'password' => Hash::make('123123123'),
        ]);

        DB::table('role_user')->insert([
            'role_id' => 1,
            'user_id' => 1,
            'user_type' => 'App\Models\User'
        ]);

        DB::table('years')->insert([
            'year' => date('Y')
        ]);
    }
}
