<?php

namespace Modules\Meeting\Admin\Pages;

use Filament\Pages\Page;
use Modules\Meeting\Admin\Resources\CoachResource;
use Morilog\Jalali\Jalalian;

class Meeting extends Page
{
    public $meeting = [];
    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    protected static string $view = 'meeting::admin.pages.meeting';

    protected static ?string $slug = "getAll/meeting";

    protected static ?string $title = 'لیست کل جلسات';

    protected static ?string $navigationGroup = 'کوچینگ';

    public static function getNavigationLabel(): string
    {
        return Jalalian::now()->format("%A, d M");
    }

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
