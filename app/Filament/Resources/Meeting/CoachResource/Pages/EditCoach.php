<?php

namespace App\Filament\Resources\Meeting\CoachResource\Pages;

use App\Filament\Resources\Meeting\CoachResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCoach extends EditRecord
{
    protected static string $resource = CoachResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
