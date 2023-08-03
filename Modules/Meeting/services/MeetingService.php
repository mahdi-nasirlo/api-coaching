<?php

namespace Modules\Meeting\services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Modules\Meeting\Entities\Meeting;

class MeetingService
{
    public static function roundToNearest15Minutes($time): string
    {
        $carbonTime = Carbon::parse($time);
        $minute = $carbonTime->format('i');
        $minute = (int)$minute;

        $remainder = $minute % 15;

        if ($remainder <= 7) {
            $roundedMinute = $minute - $remainder;
        } else {
            $roundedMinute = $minute + (15 - $remainder);
        }

        $carbonTime->setMinute($roundedMinute)->setSeconds(0);

        return $carbonTime->format('H:i');
    }

    public function NotBetweenMeetingRecords($coachId, $date, $start_time, $end_time): bool
    {
        return Meeting::query()
            ->where('date', '=', $date)
            ->where('coach_id', '=', $coachId)
            ->where(function ($query) use ($start_time, $end_time) {
                $query->where(function ($query) use ($start_time, $end_time) {
                    $query->where('start_time', '<', $end_time)
                        ->where('end_time', '>', $end_time);
                })
                    ->orWhere(function (Builder $query) use ($start_time, $end_time) {
                        $query->where('start_time', '<', $start_time)
                            ->where('end_time', '>', $start_time);
                    });
            })
            ->doesntExist();
    }
}
