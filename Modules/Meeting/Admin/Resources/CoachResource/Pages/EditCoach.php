<?php

namespace Modules\Meeting\Admin\Resources\CoachResource\Pages;

use Modules\Meeting\Admin\Resources\CoachResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCoach extends EditRecord
{
    protected static string $resource = CoachResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
