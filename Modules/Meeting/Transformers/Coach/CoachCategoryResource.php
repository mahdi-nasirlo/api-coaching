<?php

namespace Modules\Meeting\Transformers\Coach;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Meeting\Entities\CoachCategory;

/**
 * @mixin CoachCategory
 */
class CoachCategoryResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'name' => $this->name,
            'slug' => $this->slug,
        ];
    }
}
