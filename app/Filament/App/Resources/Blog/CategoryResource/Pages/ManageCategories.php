<?php

namespace App\Filament\App\Resources\Blog\CategoryResource\Pages;

use App\Filament\App\Resources\Blog\CategoryResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageCategories extends ManageRecords
{
    protected static string $resource = CategoryResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
