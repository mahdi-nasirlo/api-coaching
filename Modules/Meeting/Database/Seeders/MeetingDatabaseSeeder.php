<?php

namespace Modules\Meeting\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Meeting\Entities\Coach;

class MeetingDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     *
     */
    public function run(): void
    {
        Coach::factory()
            ->count(20)
            ->create();

        // $this->call("OthersTableSeeder");
    }
}
