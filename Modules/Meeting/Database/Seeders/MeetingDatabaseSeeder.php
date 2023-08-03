<?php

namespace Modules\Meeting\Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Modules\Meeting\Entities\BookingMeeting;
use Modules\Meeting\Entities\Coach;
use Modules\Meeting\Entities\CoachCategory;
use Modules\Meeting\Entities\Meeting;
use Modules\Meeting\Enums\MeetingStatusEnums;
use Modules\Meeting\services\MeetingService;

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

        Meeting::query()->each(function (Meeting $meeting) {

            $coach = Coach::with('meeting')->inRandomOrder()->acceptedStatus()->first();

            $meeting = Meeting::query()
                ->where('coach_id', $coach->id)->where('status', MeetingStatusEnums::ACTIVE->value)
                ->inRandomOrder()
                ->first();

            if ($meeting) {

                BookingMeeting::query()->create([
                    'user_id' => User::query()->inRandomOrder()->first()->id,
                    'coach_id' => $coach->id,
                    'meeting_id' => $meeting->id,
                    'amount' => $coach->hourly_price * MeetingService::getDiffHourlyStartAndEndTime($meeting->start_time, $meeting->end_time)
                ]);

                $meeting->update(['status' => MeetingStatusEnums::DEACTIVATE->value]);

            }
        });
    }
}
