<?php

namespace Modules\Meeting\Observers;

use Cviebrock\EloquentSluggable\Services\SlugService;
use Modules\Meeting\Entities\Coach;
use Webpatser\Uuid\Uuid;

class CoachObserver
{
    /**
     * Handle the Food "creating" event.
     */
    public function creating(Coach $coach): void
    {

        $coach->user_name = SlugService::createSlug(Coach::class, 'user_name', $coach->user_name ?: $coach->name);

        $coach->uuid = Uuid::generate(4);
    }
}
