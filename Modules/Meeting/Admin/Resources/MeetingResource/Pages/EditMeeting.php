<?php

namespace Modules\Meeting\Admin\Resources\MeetingResource\Pages;

use Modules\Meeting\Admin\Resources\MeetingResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMeeting extends EditRecord
{
    protected static string $resource = MeetingResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
