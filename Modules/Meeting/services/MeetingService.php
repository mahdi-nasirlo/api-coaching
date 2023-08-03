<?php

namespace Modules\Meeting\services;

use Illuminate\Database\Eloquent\Builder;
use Modules\Meeting\Entities\Meeting;

class MeetingService
{
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
