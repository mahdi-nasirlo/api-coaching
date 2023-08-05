<?php

namespace Modules\Meeting\Observers;

use Modules\Meeting\Entities\BookingMeeting;
use Modules\Meeting\Enums\MeetingStatusEnums;

class BookingMeetingObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(BookingMeeting $bookingMeeting): void
    {
        $bookingMeeting->meeting()->update(['status' => MeetingStatusEnums::RESERVED]);
    }
}
