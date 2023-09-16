<?php

namespace Modules\Meeting\Transformers\Meeting;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Meeting\Entities\Meeting;
use Morilog\Jalali\Jalalian;

/**
 * @mixin Meeting
 */
class AppointmentDaysResource extends JsonResource
{

    public function toArray($request): array
    {
        $date = Jalalian::fromDateTime($this->date);

        return [
            'year' => $date->getYear(),
            'month' => $date->getMonth(),
            'day' => $date->getDay(),
            'className' => $this->status->isReserved() ? "orangeDay" : 'yellowDay',
        ];
    }
}
