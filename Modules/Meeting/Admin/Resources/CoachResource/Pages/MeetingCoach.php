<?php

namespace Modules\Meeting\Admin\Resources\CoachResource\Pages;

use Filament\Resources\Pages\Page;
use Modules\Meeting\Admin\Resources\CoachResource;
use Modules\Meeting\Entities\Coach;

class MeetingCoach extends Page
{
    protected static string $resource = CoachResource::class;

    protected static string $view = 'meeting::admin.resources.coach-resource.pages.meeting-coach';

    protected static null|string $title = '';

    public $meeting;
    public $record;

    public function mount(Coach $record): void
    {
        $record->load('meeting');

        $this->record = $record;

        $this->meeting = $record->meeting->map(function ($meeting) {
            return [
                'title' => $meeting->coach->name ?? 'تایید نشده',
                'start' => $meeting->date . ' ' . $meeting->start_time,
                'end' => $meeting->date . ' ' . $meeting->end_time,
            ];
        })->toArray();
    }
}
