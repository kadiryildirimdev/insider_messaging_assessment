<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserTypesTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();

        DB::table('user_types')->insert(
            [
                [
                    'id' => Str::uuid(),
                    'code' => '00001',
                    'name' => 'İnsan Kaynakları Departmanı',
                    'created_at' => $now,
                    'updated_at' => $now,
                    'active' => true,
                ],
                [
                    'id' => Str::uuid(),
                    'code' => '00002',
                    'name' => 'Yazılım Departmanı',
                    'created_at' => $now,
                    'updated_at' => $now,
                    'active' => true,
                ],
                [
                    'id' => Str::uuid(),
                    'code' => '00003',
                    'name' => 'Muhasebe Departmanı',
                    'created_at' => $now,
                    'updated_at' => $now,
                    'active' => true,
                ]
            ]
        );
    }
}
