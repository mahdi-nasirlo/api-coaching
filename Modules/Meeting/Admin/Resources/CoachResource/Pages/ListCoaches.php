<?php

namespace Modules\Meeting\Admin\Resources\CoachResource\Pages;

use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Modules\Meeting\Admin\Resources\CoachResource;

class ListCoaches extends ListRecords
{
    protected static string $resource = CoachResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getTableQuery(): Builder
    {
        return parent::getTableQuery()->withoutGlobalScopes();
    }
}
