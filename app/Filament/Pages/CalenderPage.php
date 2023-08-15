<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Modules\Meeting\Admin\Resources\CoachResource;
use Morilog\Jalali\Jalalian;

class CalenderPage extends Page
{
    public array $meeting = [];

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.calender';

    protected static ?string $navigationGroup = "Meeting";

    public static function getNavigationLabel(): string
    {
        return Jalalian::now()->format("%A, d M");
    }

    public function mount(): void
    {
        $this->meeting = \Modules\Meeting\Entities\Meeting::all()->map(function ($meeting) {
            return [
                'title' => $meeting->coach->name ?? 'تایید نشده',
                'start' => $meeting->date . ' ' . $meeting->start_time,
                'end' => $meeting->date . ' ' . $meeting->end_time,
//                'url' => $meeting->coach?->id ? \App\Filament\Resources\Meeting\CoachResource::getUrl('view', $meeting->coach) : '',
            ];
        })->toArray();
    }
}
