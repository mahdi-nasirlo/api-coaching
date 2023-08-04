<?php

namespace Modules\Meeting\Transformers\Meeting;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;
use Modules\Meeting\Entities\Meeting;
use Modules\Meeting\services\MeetingService;

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
            'date' => Carbon::parse($this->date)->format('Y/m/d'),
            'time' => MeetingService::roundToNearest15Minutes($this->start_time) . " - " . MeetingService::roundToNearest15Minutes($this->end_time),
            'body' => $this->body,
        ];
    }
}
