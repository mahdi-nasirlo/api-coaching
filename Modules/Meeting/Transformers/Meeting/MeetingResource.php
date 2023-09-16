<?php

namespace Modules\Meeting\Transformers\Meeting;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Meeting\Entities\Meeting;
use Modules\Meeting\services\MeetingService;
use Morilog\Jalali\Jalalian;

/**
 * @mixin Meeting
 */
class MeetingResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'is_reserved ' => $this->status->isReserved(),
            'is_active' => $this->status->isActive(),
            'date' => Jalalian::fromDateTime($this->date)->format('Y-m-d'),
            'time' => MeetingService::roundToNearest15Minutes($this->start_time) . " - " . MeetingService::roundToNearest15Minutes($this->end_time),
            'body' => $this->body,
        ];
    }
}
