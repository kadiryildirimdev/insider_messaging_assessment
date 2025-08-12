<?php

namespace Database\Seeders;

use App\Enums\MessageStatusEnum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MessagesTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = \Carbon\Carbon::now();

        $messageStatus = DB::table('message_statuses')->where('code', MessageStatusEnum::NOT_SENT->value)->first();

        $messageId = DB::table('messages')->insertGetId([
            'ref_message_status' => $messageStatus?->id,
            'content' => 'Sisteme hoş geldiniz! İlk mesajınızı aldınız.',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $users = DB::table('users')->get()->toArray();

        foreach ($users as $user) {

            DB::table('message_receivers')->insert([
                'ref_message' => $messageId,
                'ref_user' => $user->id,
                'phone_number' => $user->phone_number,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}
