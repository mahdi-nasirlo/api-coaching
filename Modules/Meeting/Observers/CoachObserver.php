<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Modules\Meeting\Entities\Coach;

class CoachObserver
{
    /**
     * Handle the Food "creating" event.
     */
    public function creating(Coach $coach): void
    {
        if (!$coach->user_name && !$coach->user()->exists())
            $coach->user_name = Auth::user()->name;
        else
            $coach->user_name = Str::uuid()->toString();
    }
}
