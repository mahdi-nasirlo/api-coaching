<?php

namespace Modules\Meeting\Transformers\Coach;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Meeting\Entities\Coach;

/**
 * @mixin Coach
 */
class CoachListResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'name' => $this->name,
            'username' => $this->user_name,
            'uuid' => $this->uuid,
            'avatar' => asset('storage/' . $this->avatar),
            'hourly_price' => $this->hourly_price,
            'hourly_price_formatted' => number_format($this->hourly_price),
            'categories' => CoachCategoryResource::collection($this->whenLoaded('categories')),
        ];
    }
}
