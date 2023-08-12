<?php

namespace Modules\Blog\Admin\Resources\BlogCategoryResource\Pages;

use Modules\Blog\Admin\Resources\BlogCategoryResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBlogCategory extends EditRecord
{
    protected static string $resource = BlogCategoryResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
