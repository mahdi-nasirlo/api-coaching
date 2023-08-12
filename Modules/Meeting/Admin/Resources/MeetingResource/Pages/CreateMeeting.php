<?php

namespace Modules\Meeting\Admin\Resources\MeetingResource\Pages;

use Modules\Meeting\Admin\Resources\MeetingResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateMeeting extends CreateRecord
{
    protected static string $resource = MeetingResource::class;
}
