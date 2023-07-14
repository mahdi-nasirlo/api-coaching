<?php

namespace Modules\Meeting\Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Modules\Meeting\Entities\Meeting;

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
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'admin@local.com',
        ]);
        
       Meeting::factory()
           ->count(500)
           ->create();


        // $this->call("OthersTableSeeder");
    }
}
