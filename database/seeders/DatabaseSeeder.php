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

        DB::table('grades')->insert([
            [
               'name' => 'VU4',
               'flag' => 1,
               'delete_id' => 0
            ],
            [
                'name' => 'VU5',
                'flag' => 1,
                'delete_id' => 0
            ],
            [
                'name' => 'VU6',
                'flag' => 1,
                'delete_id' => 0
            ],
            [
                'name' => 'VU7',
                'flag' => 1,
                'delete_id' => 0
            ],
            [
                'name' => 'J54',
                'flag' => 1,
                'delete_id' => 0
            ],
            [
                'name' => 'J52',
                'flag' => 1,
                'delete_id' => 0
            ],
            [
                'name' => 'J48',
                'flag' => 1,
                'delete_id' => 0
            ],
            [
                'name' => 'J44',
                'flag' => 1,
                'delete_id' => 0
            ],
            [
                'name' => 'J41',
                'flag' => 1,
                'delete_id' => 0
            ],
            [
                'name' => 'JA38',
                'flag' => 1,
                'delete_id' => 0
            ],
            [
                'name' => 'J38',
                'flag' => 1,
                'delete_id' => 0
            ],
            [
                'name' => 'JA36',
                'flag' => 1,
                'delete_id' => 0
            ],
            [
                'name' => 'J36',
                'flag' => 1,
                'delete_id' => 0
            ],
            [
                'name' => 'JA30',
                'flag' => 1,
                'delete_id' => 0
            ],
            [
                'name' => 'J30',
                'flag' => 1,
                'delete_id' => 0
            ],
            [
                'name' => 'JA29',
                'flag' => 1,
                'delete_id' => 0
            ],
            [
                'name' => 'J29',
                'flag' => 1,
                'delete_id' => 0
            ],
            [
                'name' => 'JA26',
                'flag' => 1,
                'delete_id' => 0
            ],
            [
                'name' => 'J26',
                'flag' => 1,
                'delete_id' => 0
            ],
            [
                'name' => 'JA22',
                'flag' => 1,
                'delete_id' => 0
            ],
            [
                'name' => 'J22',
                'flag' => 1,
                'delete_id' => 0
            ],
            [
                'name' => 'J19',
                'flag' => 1,
                'delete_id' => 0
            ],
            [
                'name' => 'JA17',
                'flag' => 1,
                'delete_id' => 0
            ],
            [
                'name' => 'J17',
                'flag' => 1,
                'delete_id' => 0
            ],
        ]);

        DB::table('dict_col_grades_categories')->insert([
            [
                'name' => 'Pengurusan dan Profesional',
                'flag' => 1,
                'delete_id' => 0
            ],
            [
                'name' => 'Kumpulan Pelaksana',
                'flag' => 1,
                'delete_id' => 0
            ]
        ]);

        DB::table('dict_col_grades')->insert([
            [
                'dict_col_grades_categories_id' => 1,
                'grades_id' => 1,
                'flag' => 1,
                'delete_id' => 0
            ],
            [
                'dict_col_grades_categories_id' => 1,
                'grades_id' => 2,
                'flag' => 1,
                'delete_id' => 0
            ],
            [
                'dict_col_grades_categories_id' => 1,
                'grades_id' => 3,
                'flag' => 1,
                'delete_id' => 0
            ],
            [
                'dict_col_grades_categories_id' => 1,
                'grades_id' => 4,
                'flag' => 1,
                'delete_id' => 0
            ],
            [
                'dict_col_grades_categories_id' => 1,
                'grades_id' => 5,
                'flag' => 1,
                'delete_id' => 0
            ],
            [
                'dict_col_grades_categories_id' => 1,
                'grades_id' => 6,
                'flag' => 1,
                'delete_id' => 0
            ],
            [
                'dict_col_grades_categories_id' => 1,
                'grades_id' => 7,
                'flag' => 1,
                'delete_id' => 0
            ],
            [
                'dict_col_grades_categories_id' => 1,
                'grades_id' => 8,
                'flag' => 1,
                'delete_id' => 0
            ],
            [
                'dict_col_grades_categories_id' => 1,
                'grades_id' => 9,
                'flag' => 1,
                'delete_id' => 0
            ],
            [
                'dict_col_grades_categories_id' => 2,
                'grades_id' => 10,
                'flag' => 1,
                'delete_id' => 0
            ],
            [
                'dict_col_grades_categories_id' => 2,
                'grades_id' => 11,
                'flag' => 1,
                'delete_id' => 0
            ],
            [
                'dict_col_grades_categories_id' => 2,
                'grades_id' => 12,
                'flag' => 1,
                'delete_id' => 0
            ],
            [
                'dict_col_grades_categories_id' => 2,
                'grades_id' => 13,
                'flag' => 1,
                'delete_id' => 0
            ],
            [
                'dict_col_grades_categories_id' => 2,
                'grades_id' => 14,
                'flag' => 1,
                'delete_id' => 0
            ],
            [
                'dict_col_grades_categories_id' => 2,
                'grades_id' => 15,
                'flag' => 1,
                'delete_id' => 0
            ],
            [
                'dict_col_grades_categories_id' => 2,
                'grades_id' => 16,
                'flag' => 1,
                'delete_id' => 0
            ],
            [
                'dict_col_grades_categories_id' => 2,
                'grades_id' => 17,
                'flag' => 1,
                'delete_id' => 0
            ],
            [
                'dict_col_grades_categories_id' => 2,
                'grades_id' => 18,
                'flag' => 1,
                'delete_id' => 0
            ],
            [
                'dict_col_grades_categories_id' => 2,
                'grades_id' => 19,
                'flag' => 1,
                'delete_id' => 0
            ],
            [
                'dict_col_grades_categories_id' => 2,
                'grades_id' => 20,
                'flag' => 1,
                'delete_id' => 0
            ],
            [
                'dict_col_grades_categories_id' => 2,
                'grades_id' => 21,
                'flag' => 1,
                'delete_id' => 0
            ],
            [
                'dict_col_grades_categories_id' => 2,
                'grades_id' => 22,
                'flag' => 1,
                'delete_id' => 0
            ],
            [
                'dict_col_grades_categories_id' => 2,
                'grades_id' => 23,
                'flag' => 1,
                'delete_id' => 0
            ],
            [
                'dict_col_grades_categories_id' => 2,
                'grades_id' => 24,
                'flag' => 1,
                'delete_id' => 0
            ]
        ]);

        DB::table('dict_col_scale_lvls_skillsets')->insert([
            [
                'name' => 'Poor',
                'flag' => 1,
                'delete_id' => 0
            ],
            [
                'name' => 'Basic',
                'flag' => 1,
                'delete_id' => 0
            ],
            [
                'name' => 'Proficient',
                'flag' => 1,
                'delete_id' => 0
            ],
            [
                'name' => 'Mastery',
                'flag' => 1,
                'delete_id' => 0
            ],
            [
                'name' => 'Entry',
                'flag' => 1,
                'delete_id' => 0
            ],
            [
                'name' => 'Competent',
                'flag' => 1,
                'delete_id' => 0
            ],
            [
                'name' => 'Expert',
                'flag' => 1,
                'delete_id' => 0
            ],
            [
                'name' => 'Strategies',
                'flag' => 1,
                'delete_id' => 0
            ],
            [
                'name' => 'None',
                'flag' => 1,
                'delete_id' => 0
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
