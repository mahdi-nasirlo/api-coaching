<?php

namespace Modules\Meeting\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Meeting\Entities\BookingMeeting;
use Modules\Meeting\Entities\Meeting;
use Modules\Meeting\Enums\MeetingStatusEnums;
use Modules\Meeting\services\MeetingService;

/**
 * TODO: return transaction id in success payment with response
 * TODO: return unsuccessful payment response
 * TODO: store cart item in transaction ID
 */
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

        Meeting::query()->inRandomOrder()->get()->take(rand(3, Meeting::all()->count()))->each(function (Meeting $meeting) {

            $meeting->transaction()->create([
                'resnumber' => md5(uniqid()),
                'verify_code' => md5(uniqid()),
                'amount' => MeetingService::getTotalPrice($meeting)
            ]);

            $meeting->update(['status' => MeetingStatusEnums::RESERVED->value]);

            $meeting->transaction()->update(['status' => 1]);

        });
    }
}
