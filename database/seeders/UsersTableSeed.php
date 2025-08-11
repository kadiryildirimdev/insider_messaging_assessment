<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = \Carbon\Carbon::now();

        $userTypeIds = DB::table('user_types')->pluck('id');

        foreach($userTypeIds as $key => $userTypeId) {
            for($i = 0; $i < random_int(3,10); $i++) {
                $faker = \Faker\Factory::create('tr_TR');

                DB::table('users')->insert([
                    'ref_user_type' => $userTypeId,
                    'full_name' => $faker->name,
                    'phone_number' => '009055388762'. $key . $i,
                    'email' => 'user' . $key . $i . '@gmail.com',
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }
    }
}
