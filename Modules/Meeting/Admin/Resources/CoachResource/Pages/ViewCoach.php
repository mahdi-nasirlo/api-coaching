<?php

namespace Modules\Meeting\Admin\Resources\CoachResource\Pages;

use Filament\Resources\Pages\Page;
use Modules\Meeting\Admin\Resources\CoachResource;
use Modules\Meeting\Entities\Meeting;

class ViewCoach extends Page
{
    protected static string $resource = CoachResource::class;

    protected static string $view = 'meeting::admin.resources.coach-resource.pages.view-coach';

    public function mount(Meeting $record): void
    {

    }
}
