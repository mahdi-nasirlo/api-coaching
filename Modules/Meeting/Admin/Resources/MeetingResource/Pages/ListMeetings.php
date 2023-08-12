<?php

namespace Modules\Meeting\Admin\Resources\MeetingResource\Pages;

use Modules\Meeting\Admin\Resources\MeetingResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMeetings extends ListRecords
{
    protected static string $resource = MeetingResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
