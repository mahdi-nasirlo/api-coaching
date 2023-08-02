<?php

namespace Modules\Meeting\Transformers\Meeting;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Meeting\Entities\Meeting;

/**
 * @mixin Meeting
 */
class MeetingResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'body' => $this->body,
            'date' => $this->date,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
        ];
    }
}
