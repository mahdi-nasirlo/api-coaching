<?php

namespace App\Filament\Resources\Meeting\CoachResource\Pages;

use App\Filament\Resources\Meeting\CoachResource;
use Filament\Resources\Pages\Page;

class CalenderCoach extends Page
{
    protected static string $resource = CoachResource::class;

    protected static string $view = 'filament.app.resources.meeting.coach-resource.pages.calender';
}
