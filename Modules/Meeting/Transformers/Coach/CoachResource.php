<?php

namespace Modules\Meeting\Transformers\Coach;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Meeting\Entities\Coach;
use Modules\Meeting\Entities\CoachInfo;

/**
 * @mixin Coach
 * @mixin CoachInfo
 */
class CoachResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'name' => $this->name,
            'username' => $this->user_name,
            'uuid' => $this->uuid,
            'categories' => CoachCategoryResource::collection($this->whenLoaded('categories')),
            'avatar' => asset('storage/avatars/' . $this->avatar),
            'status' => $this->status,
            'hourly_price' => $this->hourly_price,
            'hourly_price_formatted' => number_format($this->hourly_price),
            'about_me' => $this->about_me,
            'job_experience' => $this->job_experience,
            'education' => $this->education_recorde,
        ];
    }
}
