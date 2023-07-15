<?php

namespace Modules\Meeting\Admin\Pages;

use Filament\Pages\Page;

class Meeting extends Page
{
    public $meeting = [];
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'meeting::admin.pages.meeting';

    public function mount()
    {
        $this->meeting = \Modules\Meeting\Entities\Meeting::all()->take(20)->map(function ($meeting) {
            return [
                'title' => $meeting->coach->name,
                'start' => $meeting->date . ' ' .$meeting->start_time,
                'end' => $meeting->date . ' ' . $meeting->end_time ,
//                'startTime' => $meeting->start_time,
//                'endTime' => $meeting->end_time,
            ];
        })->toArray();
    }
}
