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
        /* it should be copy from dict_col_measuring_lvls table - by rubmin
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
        */

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

        DB::table('dict_col_scale_lvls')->insert([
            [
                'name' => 'Scale Language',
                'flag' => 1,
                'delete_id' => 0,
            ],
            [
                'name' => '1-6',
                'flag' => 1,
                'delete_id' => 0,
            ],
            [
                'name' => 'Yes/No',
                'flag' => 1,
                'delete_id' => 0,
            ],
            [
                'name' => 'Scale ICT',
                'flag' => 1,
                'delete_id' => 0,
            ]
        ]);

        DB::table('dict_col_scale_lvls_sets')->insert([
            //Scale Language
            [
                'dict_col_scale_lvls_id' => 1,
                'dict_col_scale_lvls_skillsets_id' => 1,
                'name' => 'Poor command of the language',
                'score' => 0,
                'flag' => 1,
                'delete_id' => 0,
            ],
            [
                'dict_col_scale_lvls_id' => 1,
                'dict_col_scale_lvls_skillsets_id' => 2,
                'name' => 'Able to read and write reasonably well and appreciate a wide variety of texts as well as those pretinent to professional needs',
                'score' => 0,
                'flag' => 1,
                'delete_id' => 0,
            ],
            [
                'dict_col_scale_lvls_id' => 1,
                'dict_col_scale_lvls_skillsets_id' => 3,
                'name' => 'Able to read and write fluently and accurately in all styles and forms of the language on any subject as well as those pertinent to professional needs',
                'score' => 0,
                'flag' => 1,
                'delete_id' => 0,
            ],
            [
                'dict_col_scale_lvls_id' => 1,
                'dict_col_scale_lvls_skillsets_id' => 4,
                'name' => 'Have mastery of the languagel; near native; ability to read, understand and write extremly difficult of abstract prose, a wide variety of vocabulary, idioms colloquialisms, and slang',
                'score' => 0,
                'flag' => 1,
                'delete_id' => 0,
            ],
            //1-6
            [
                'dict_col_scale_lvls_id' => 2,
                'dict_col_scale_lvls_skillsets_id' => 5,
                'name' => 'You are not trained and have no experience',
                'score' => 0,
                'flag' => 1,
                'delete_id' => 0,
            ],
            [
                'dict_col_scale_lvls_id' => 2,
                'dict_col_scale_lvls_skillsets_id' => 2,
                'name' => 'You are still learning and have had some prior exposure or have basic knowledge or have had some practice. You are able to analyse and interpret information. Supervision is needed. You know where to obtain help',
                'score' => 0,
                'flag' => 1,
                'delete_id' => 0,
            ],
            [
                'dict_col_scale_lvls_id' => 2,
                'dict_col_scale_lvls_skillsets_id' => 6,
                'name' => 'You are able to directly apply techniques and use tools/equipment independently. Supervision is necessary from time to time. You are able to diagnose issues, anticipate problems and provide reasoning. You work with practisioners in a specific skill area',
                'score' => 0,
                'flag' => 1,
                'delete_id' => 0,
            ],
            [
                'dict_col_scale_lvls_id' => 2,
                'dict_col_scale_lvls_skillsets_id' => 3,
                'name' => 'You have substantial experience and are able to supervise others. You demonstrate this skill independently almost all the time. You are able to diagnose issues, anticipate problems and provide reasoning. You work with practicitoners in a specific skill area.',
                'score' => 0,
                'flag' => 1,
                'delete_id' => 0,
            ],
            [
                'dict_col_scale_lvls_id' => 2,
                'dict_col_scale_lvls_skillsets_id' => 7,
                'name' => 'You are a source or reference to others who seek advice in a particular area/field. You are able to develop and mentor others in technique, procedure or process. Able to create best practice in the organisation or in a broader context.',
                'score' => 0,
                'flag' => 1,
                'delete_id' => 0,
            ],
            [
                'dict_col_scale_lvls_id' => 2,
                'dict_col_scale_lvls_skillsets_id' => 8,
                'name' => 'You have the skills to set policies and provide overall direction. ',
                'score' => 0,
                'flag' => 1,
                'delete_id' => 0,
            ],
            //Scale ICT
            [
                'dict_col_scale_lvls_id' => 4,
                'dict_col_scale_lvls_skillsets_id' => 9,
                'name' => 'No knowledge of the software applications',
                'score' => 0,
                'flag' => 1,
                'delete_id' => 0,
            ],
            [
                'dict_col_scale_lvls_id' => 4,
                'dict_col_scale_lvls_skillsets_id' => 2,
                'name' => 'Basic knowledge of software applications; may understand and/or apply some parts of the software applications.',
                'score' => 0,
                'flag' => 1,
                'delete_id' => 0,
            ],
            [
                'dict_col_scale_lvls_id' => 4,
                'dict_col_scale_lvls_skillsets_id' => 3,
                'name' => 'Can understand & apply software applications well',
                'score' => 0,
                'flag' => 1,
                'delete_id' => 0,
            ],
            [
                'dict_col_scale_lvls_id' => 4,
                'dict_col_scale_lvls_skillsets_id' => 4,
                'name' => 'High proficiency in understanding, applying & teaching of software applications',
                'score' => 0,
                'flag' => 1,
                'delete_id' => 0,
            ],
        ]);

        DB::table('dict_col_competency_types')->insert([
            [
                'name' => 'Behavioural',
                'flag' => 1,
                'delete_id' => 0
            ],
            [
                'name' => 'Functional',
                'flag' => 1,
                'delete_id' => 0
            ],
            [
                'name' => 'Generic',
                'flag' => 1,
                'delete_id' => 0
            ],
            [
                'name' => 'ICT',
                'flag' => 1,
                'delete_id' => 0
            ],
            [
                'name' => 'Language',
                'flag' => 1,
                'delete_id' => 0
            ],
            [
                'name' => 'Technical (Discipline)',
                'flag' => 1,
                'delete_id' => 0
            ],
            [
                'name' => 'Technical (Generic)',
                'flag' => 1,
                'delete_id' => 0
            ]
        ]);

        DB::table('dict_col_competency_types_scale_lvls')->insert([
            [
                'dict_col_competency_types_id' => 1,
                'dict_col_scale_lvls_id' => 3,
                'flag' => 1,
                'delete_id' => 0,
            ],
            [
                'dict_col_competency_types_id' => 2,
                'dict_col_scale_lvls_id' => 2,
                'flag' => 1,
                'delete_id' => 0,
            ],
            [
                'dict_col_competency_types_id' => 3,
                'dict_col_scale_lvls_id' => 3,
                'flag' => 1,
                'delete_id' => 0,
            ],
            [
                'dict_col_competency_types_id' => 4,
                'dict_col_scale_lvls_id' => 4,
                'flag' => 1,
                'delete_id' => 0,
            ],
            [
                'dict_col_competency_types_id' => 5,
                'dict_col_scale_lvls_id' => 1,
                'flag' => 1,
                'delete_id' => 0,
            ],
            [
                'dict_col_competency_types_id' => 6,
                'dict_col_scale_lvls_id' => 2,
                'flag' => 1,
                'delete_id' => 0,
            ],
            [
                'dict_col_competency_types_id' => 7,
                'dict_col_scale_lvls_id' => 2,
                'flag' => 1,
                'delete_id' => 0,
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
