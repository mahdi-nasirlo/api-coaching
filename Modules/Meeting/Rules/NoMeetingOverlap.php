<?php

namespace Modules\Meeting\Rules;

use Illuminate\Contracts\Validation\Rule;
use Modules\Meeting\Entities\Coach;
use Modules\Meeting\services\MeetingService;


class NoMeetingOverlap implements Rule
{
    protected string $date;
    protected string $startTime;
    protected string $endTime;
    protected Coach $coach;

    public function __construct($coachId, $date, $startTime, $endTime)
    {
        $this->coach = $coachId;
        $this->date = $date;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        $meetingService = new MeetingService();

        return $meetingService->NotBetweenMeetingRecords(
            $this->coach->id, $this->date, $this->startTime, $this->endTime
        );
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'The selected meeting time overlaps with an existing meeting.';
    }
}
