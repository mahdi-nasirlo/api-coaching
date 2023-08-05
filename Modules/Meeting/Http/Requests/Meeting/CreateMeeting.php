<?php

namespace Modules\Meeting\Http\Requests\Meeting;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Meeting\Rules\NoMeetingOverlap;

/**
 * @property mixed $date
 * @property mixed $start_time
 * @property mixed $end_time
 */
class CreateMeeting extends FormRequest
{
    public function rules(): array
    {
        return [
            'date' => [
                'required',
                'date_format:Y/m/d',
                new NoMeetingOverlap($this->route('coach'), $this->date, $this->start_time, $this->end_time)
            ],
            'start_time' => [
                'before:end_time',
                'required',
                'date_format:H:i:s'
            ],
            'end_time' => [
                'required',
                'date_format:H:i:s'
            ],
            'body' => [
                'nullable',
                'string',
                'min:5',
                'max:1024'
            ],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
