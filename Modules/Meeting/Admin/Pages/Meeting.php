<?php

namespace Modules\Meeting\Admin\Pages;

use Filament\Pages\Page;
use Modules\Meeting\Admin\Resources\CoachResource;

class Meeting extends Page
{
    public $meeting = [];
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'meeting::admin.pages.meeting';

    public function mount()
    {
        $this->meeting = \Modules\Meeting\Entities\Meeting::all()->map(function ($meeting) {
            return [
                'title' => $meeting->coach->name ?? 'تایید نشده',
                'start' => $meeting->date . ' ' . $meeting->start_time,
                'end' => $meeting->date . ' ' . $meeting->end_time,
                'url' => $meeting->coach?->id ? CoachResource::getUrl('view', $meeting->coach) : '',
            ];
        })->toArray();
    }
}
