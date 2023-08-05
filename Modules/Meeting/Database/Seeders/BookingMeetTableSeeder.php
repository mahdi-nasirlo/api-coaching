<?php

namespace Modules\Meeting\Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Modules\Meeting\Entities\BookingMeeting;
use Modules\Meeting\Entities\Coach;
use Modules\Meeting\Entities\Meeting;
use Modules\Meeting\Enums\MeetingStatusEnums;
use Modules\Meeting\services\MeetingService;

class BookingMeetTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        BookingMeeting::query()->truncate();

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

                $meeting->update(['status' => MeetingStatusEnums::RESERVED->value]);

            }
        });
    }
}
