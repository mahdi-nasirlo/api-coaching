<?php

namespace Modules\Meeting\Admin\Resources\CoachResource\Pages;

use Filament\Resources\Pages\EditRecord;
use Modules\Meeting\Admin\Resources\CoachResource;

class EditCoach extends EditRecord
{
    protected static string $resource = CoachResource::class;

    protected function getActions(): array
    {
        return [

        ];
    }
}
