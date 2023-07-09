<?php

namespace Modules\Meeting\Admin\Resources\CoachResource\Pages;

use Modules\Meeting\Admin\Resources\CoachResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCoach extends CreateRecord
{
    protected static string $resource = CoachResource::class;
}
