<?php

namespace Modules\Meeting\services;

use Illuminate\Http\Request;
use Modules\Meeting\Entities\Coach;

class CoachService
{
    public function uploadAvatar(Request $request): string
    {
        $file = $request->file('avatar');

        $filename = uniqid() . '.' . $file->getClientOriginalExtension();

        $file->storeAs('public/avatars', $filename);

        return $filename;
    }

    public function syncCategories(Request $request, Coach $coach): void
    {
        $categories = $request['categories'];

        $coach->categories()->sync($categories);
    }
}
