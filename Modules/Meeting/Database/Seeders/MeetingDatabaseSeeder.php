<?php

namespace Modules\Meeting\Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Modules\Meeting\Entities\Coach;
use Modules\Meeting\Entities\CoachCategory;
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

        CoachCategory::factory()->count(20)->create();

        $categories = CoachCategory::all();

        Coach::query()->each(function (Coach $coach) use ($categories) {

            $categoryIds = $categories->random(rand(1, 3))->pluck('id')->toArray();

            $coach->categories()->syncWithoutDetaching($categoryIds);

        });


        // $this->call("OthersTableSeeder");
    }
}
