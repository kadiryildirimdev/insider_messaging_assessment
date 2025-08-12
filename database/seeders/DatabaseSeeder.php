<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        /**
         * Definitions
         */
        $this->call(UserTypesTableSeed::class);
        $this->call(MessagesStatusesTableSeed::class);

        /**
         * Sample Data
         */
        $this->call(UsersTableSeed::class);
        $this->call(MessagesTableSeed::class);
    }
}
