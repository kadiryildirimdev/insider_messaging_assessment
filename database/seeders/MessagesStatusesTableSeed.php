<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MessagesStatusesTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();

        DB::table('message_statuses')->insert(
            [
                [
                    'id' => Str::uuid(),
                    'code' => '00001',
                    'name' => 'Gönderildi',
                    'created_at' => $now,
                    'updated_at' => $now,
                    'active' => true,
                ],
                [
                    'id' => Str::uuid(),
                    'code' => '00002',
                    'name' => 'Gönderilmedi',
                    'created_at' => $now,
                    'updated_at' => $now,
                    'active' => true,
                ]
            ]
        );
    }
}
