<?php

namespace Modules\Meeting\Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
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
        User::query()->updateOrCreate(
            ['email' => 'admin@local.com'],
            [
                'name' => 'test user',
                'password' => Hash::make('password'),
            ]
        );

        Meeting::factory()
            ->count(100)
            ->create();

        $this->call([
            CategoryMeetTableSeeder::class,
            BookingMeetTableSeeder::class,
        ]);

    }
}
